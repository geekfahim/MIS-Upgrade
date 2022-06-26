<?php

namespace App\Http\Controllers\Jeebika\Reports;

use App\Enums\IGA\JBusinessPlanStatus;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectReportController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.reports.project-report');
    }

    public function download(Request $request)
    {
        $rules = [
            'report_type'   => ['required', Rule::in('full', 'summary')],
            'download_type' => ['required', 'in:pdf,xls,view'],
            'ids'           => ['required', 'array'],
            'ids.*'         => ['required', 'integer', Rule::exists(JGro::getTableName(), 'id')],
        ];
        $request->validate($rules);

        $jProject = JProject::find($request->j_project_id);

        if ('summary' == $request->report_type) {
            return $this->_summaryReport($request);
        }
    }

    private function _summaryReport(Request $request)
    {
        $data = JProject::with(['district', 'manager', 'sponsors', 'district',
            'gros'     => function ($builder) {
                $builder->with(['leader', 'families', 'businessPlans'])
                    ->withCount(['families', 'businessPlans' => function ($builder) {
                        $builder->where('status', JBusinessPlanStatus::Ongoing)
                            ->orWhere('status', JBusinessPlanStatus::Approved);
                    }])
                    ->withSum('j_equities', 'approved_amount');
            },
            'families' => function ($builder) {
                $builder->with(['family']);
            }])
            ->withCount('j_implementations', 'gros', 'sponsors', 'field_officers', 'families')
            ->whereIn('id', $request->ids)->get();
        if ('pdf' == $request->download_type) {
            $file_name = "Report_project_summary_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.project-summary', compact('data'))->setOptions(getPDFOptions())->setOption('margin-bottom', 0)->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_project_summary_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.project-summary', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.project-summary', compact('data'));
        }
    }
}
