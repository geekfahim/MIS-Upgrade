<?php

namespace App\Http\Controllers\Jeebika\Reports;

use App\Enums\FamilyStatus;
use App\Enums\JHealthSessionStatus;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyMember;
use App\Models\Jeebika\HealthSession\JHealthSession;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class HealthSessionReportController extends Controller
{
    public function index()
    {
        return view('dashboard.jeebika.reports.health-session-report');
    }

    public function getTrainingByProjectId(Request $request): JsonResponse
    {
        $request->validate([
            'j_project_id' => ['required', Rule::exists(JProject::getTableName(), 'id')],
            'report_type'  => ['required', Rule::in('summary', 'family-wise', 'individual-participant', 'trade-wise')],
            'from_date'    => [Rule::when($request->report_type == 'summary', ['required', 'date'])],
            'to_date'      => [Rule::when($request->report_type == 'summary', ['required', 'date', 'after:from_date'])],
            'j_gro_id'     => [Rule::exists(JGro::getTableName(), 'id'), Rule::when($request->report_type == 'family-wise' || $request->report_type == 'individual-participant', 'required', 'nullable')],
        ],
            [
                'j_project_id.required' => 'the project field is required',
            ]);
        if ($request->report_type === 'summary') {
            $data = JHealthSession::select('id', 'session_heading', 'start_date')->where('j_project_id', $request->j_project_id)->whereBetween('start_date', [$request->from_date, $request->to_date])->whereStatus(JHealthSessionStatus::Complete)->get();
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
            $family = Jeebika::with('family')->where('j_project_id', $request->j_project_id)
                ->where('j_gro_id', $request->j_gro_id)->pluck('family_id');
            $data = FamilyMember::with('family:id,name', 'mustahiq:id,name')->whereIn('family_id', $family)->get();
            return response()->json($data, Response::HTTP_OK);
        } else
            return response()->json(['message' => 'Proper report type  not selected'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function download(Request $request)
    {
        $request->validate([
            'report_type'   => ['required', Rule::in('summary', 'family-wise', 'individual-participant')],
            'download_type' => ['required', 'in:pdf,xls,view'],
            'ids'           => ['required', 'array'],
            'ids.*'         => ['required', 'integer'],
            'j_project_id'  => ['required', Rule::exists(JProject::getTableName(), 'id')],
            'j_gro_id'      => [Rule::when('report_type' == 'family-wise', ['required', 'array'])],
            'j_gro_id.*'    => [Rule::exists(JGro::getTableName(), 'id')],
        ]);

        $jProject = JProject::find($request->j_project_id);
        if ('summary' == $request->report_type) {
            return $this->_summaryReport($request, $jProject);
        }
        if ('family-wise' == $request->report_type) {
            return $this->_familyHealthSessionReport($request, $jProject);
        }
        if ('individual-participant' == $request->report_type) {
            return $this->_participantHealthSessionReport($request, $request->ids);
        }
    }

    private function _summaryReport(Request $request, JProject $jProject)
    {
        $data = JHealthSession::with(['j_project:id,name', 'health_session_present_mustahiqs'])->whereIn('id', $request->ids)->get();

        if ('pdf' === $request->download_type) {
            $file_name = "Report_health_session_summary_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.health-session-summary', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' === $request->download_type) {
            $file_name = "Report_health_session_summary_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.health-session-summary', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' === $request->download_type) {
            return view('dashboard.jeebika.download.health-session-summary', compact('data'));
        }
    }

    private function _familyHealthSessionReport(Request $request, JProject $project)
    {
        $data = Family::with([
            'members_info' => function ($builder) {
                $builder->with(['j_health_session']);
            },
            'jeebika'      => function ($builder) {
                $builder->with('j_project', 'j_gro');
            }])
            ->select('id', 'name', 'number_of_family_member', 'family_headed_by', 'total_room', 'house_type', 'family_headed_by')
            ->whereStatus(FamilyStatus::Active)->whereIn('id', $request->ids)->get();

        if ('pdf' == $request->download_type) {
            $file_name = "Report_health_session_family_wise_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.health-session-family-wise', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_health_session_family_wise_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.health-session-family-wise', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.health-session-family-wise', compact('data'));
        }
    }

    private function _participantHealthSessionReport(Request $request, $ids)
    {
        $data = FamilyMember::with([
            'family:id,name', 'mustahiq' => function ($builder) {
                $builder->select('id', 'name', 'mobile')->with('j_health_session');
            },
                              'jeebika'  => function ($builder) {
                                  $builder->with('j_project', 'j_gro');
                              }])->whereIn('mustahiq_id', $ids)->get();

        if ('pdf' == $request->download_type) {
            $file_name = "Report_health_session_participant_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.health-session-participant-wise', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_health_session_participant_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.health-session-participant-wise', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.health-session-participant-wise', compact('data'));
        }
    }
}
