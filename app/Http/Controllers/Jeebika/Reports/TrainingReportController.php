<?php

namespace App\Http\Controllers\Jeebika\Reports;

use App\Enums\FamilyStatus;
use App\Enums\JTrainingStatus;
use App\Enums\JTrainingType;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyMember;
use App\Models\Base\Settings\Skill;
use App\Models\Base\Settings\Vocational;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Training\JTraining;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class TrainingReportController extends Controller
{
    public function index()
    {
        return view('dashboard.jeebika.reports.training-report');
    }

    public function getTrainingByProjectId(Request $request): JsonResponse
    {
        $request->validate([
            'j_project_id' => ['required', Rule::exists(JProject::getTableName(), 'id')],
            'report_type' => ['required', Rule::in('training-summary', 'family-wise', 'individual-participant', 'trade-wise')],
            'from_date' => [Rule::when($request->report_type == 'training-summary', ['required', 'date'])],
            'to_date' => [Rule::when($request->report_type == 'training-summary', ['required', 'date', 'after:from_date'])],
            'j_gro_id' => [Rule::exists(JGro::getTableName(), 'id'), Rule::when($request->report_type == 'family-wise' || $request->report_type == 'individual-participant', 'required', 'nullable')],
            'training_type' => [Rule::in('Vocational', 'Skill'), Rule::when($request->report_type == 'trade-wise', 'required', 'nullable')]
        ],
            [
                'j_project_id.required' => 'the project field is required',
            ]);
        if ($request->report_type === 'training-summary') {
            $data = JTraining::select('id', 'training_heading', 'start_date')->where('j_project_id', $request->j_project_id)->whereBetween('start_date', [$request->from_date, $request->to_date])->whereStatus(JTrainingStatus::Complete)->get();
            if (count($data) > 0) {
                return response()->json($data, Response::HTTP_OK);
            } else
                return response()->json(['message' => 'No data Found'], Response::HTTP_NOT_FOUND);
        }
        if ($request->report_type === 'family-wise') {
            $data = Jeebika::with(['family' => function ($builder) {
                $builder->select('id', 'name');
            }])->where('j_project_id', $request->j_project_id)->where('j_gro_id', $request->j_gro_id)->get();
            return response()->json($data, Response::HTTP_OK);
        }
        if ($request->report_type === 'individual-participant') {
            $family = Jeebika::with('family')->where('j_project_id', $request->j_project_id)->where('j_gro_id', $request->j_gro_id)->pluck('family_id');
            $data = FamilyMember::with('family:id,name', 'mustahiq:id,name')->whereIn('family_id', $family)->get();
            return response()->json($data, Response::HTTP_OK);
        }
        if ($request->report_type === 'trade-wise') {
            if ($request->training_type === 'Vocational') {
                $data = Vocational::select('id', 'name')->get();
            }
            if ($request->training_type === 'Skill') {
                $data = Skill::select('id', 'name')->get();
            }
            return response()->json($data, Response::HTTP_OK);
        } else
            return response()->json(['message' => 'Proper report type  not selected'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function download(Request $request)
    {
        $request->validate([
            'report_type' => ['required', Rule::in('training-summary', 'family-wise', 'individual-participant', 'trade-wise')],
            'download_type' => ['required', 'in:pdf,xls,view'],
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'integer'],
            'j_project_id' => ['required', Rule::exists(JProject::getTableName(), 'id')],
            'j_gro_id' => [Rule::when('report_type' == 'family-wise', ['required', 'array'])],
            'j_gro_id.*' => [Rule::exists(JGro::getTableName(), 'id')],
        ]);

        $jProject = JProject::find($request->j_project_id);
        if ('training-summary' == $request->report_type) {
            return $this->_summaryReport($request, $jProject);
        }
        if ('family-wise' == $request->report_type) {
            return $this->_familyTrainingReport($request, $jProject);
        }
        if ('individual-participant' == $request->report_type) {
            return $this->_participantTrainingReport($request, $request->ids);
        }
        if ('trade-wise' == $request->report_type) {
            return $this->_tradeTrainingReport($request, $request->j_project_id, $request->ids);
        }
    }

    private function _summaryReport(Request $request, JProject $jProject)
    {
        $data = JTraining::with(['j_project:id,name', 'training_present_mustahiqs' => function ($builder) {
            $builder->with(['vocational_needs.vocational:id,name', 'vocational_haves.vocational:id,name', 'skill_needs.skill:id,name',
                'skill_haves.skill:id,name', 'member', 'j_training:id,training_heading,training_type']);
        }])->whereIn('id', $request->ids)->get();

        if ('pdf' === $request->download_type) {
            $file_name = "Report_training_summary_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.training-summary', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' === $request->download_type) {
            $file_name = "Report_training_summary_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.training-summary', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' === $request->download_type) {
            return view('dashboard.jeebika.download.training-summary', compact('data'));
        }
    }

    private function _familyTrainingReport(Request $request, JProject $project)
    {
        $data = Family::with([
            'members_info' => function ($builder) {
                $builder->with(['j_training', 'vocationals.vocational', 'skills.skill', 'vocational_needs.vocational:id,name', 'vocational_haves.vocational:id,name', 'skill_needs.skill:id,name', 'skill_haves.skill:id,name']);
            },
            'jeebika' => function ($builder) {
                $builder->with('j_project', 'j_gro');
            }])->select('id', 'name', 'number_of_family_member', 'family_headed_by', 'total_room', 'house_type', 'family_headed_by')->whereStatus(FamilyStatus::Active)->whereIn('id', $request->ids)->get();

        if ('pdf' == $request->download_type) {
            $file_name = "Report_training_family_wise_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.training-family-wise', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_training_family_wise_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.training-family-wise', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.training-family-wise', compact('data'));
        }
    }

    private function _participantTrainingReport(Request $request, $ids)
    {
        $data = FamilyMember::with([
            'family:id,name', 'mustahiq' => function ($builder) {
                $builder->select('id', 'name', 'mobile')->with('j_training');
            }, 'jeebika' => function ($builder) {
                $builder->with('j_project', 'j_gro');
            }])->whereIn('mustahiq_id', $ids)->get();

        if ('pdf' == $request->download_type) {
            $file_name = "Report_training_participant_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.training-participant-wise', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_training_participant_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.training-participant-wise', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.training-participant-wise', compact('data'));
        }
    }

    private function _tradeTrainingReport(Request $request, $jProjectId, $ids)
    {
        if ($request->training_type === 'Vocational') {
            $data = JTraining::select(JTraining::ListKey())->with('vocational', 'mustahiqs', 'j_project:id,name')->where('training_type', JTrainingType::Vocational)->where('j_project_id', $jProjectId)->whereIn('vocational_id', $ids)->get();
        }
        if ($request->training_type === 'Skill') {
            $data = JTraining::select(JTraining::ListKey())->with('skill', 'mustahiqs', 'j_project:id,name')->where('training_type', JTrainingType::Skill)->where('j_project_id', $jProjectId)->whereIn('skill_id', $ids)->get();
        }
        if ('pdf' == $request->download_type) {
            $file_name = "Report_training_trade_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.training-trade-wise', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_training_trade_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.training-trade-wise', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.training-trade-wise', compact('data'));
        }
    }
}
