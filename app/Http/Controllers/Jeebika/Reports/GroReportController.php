<?php

namespace App\Http\Controllers\Jeebika\Reports;

use App\Enums\FamilyStatus;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class GroReportController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.reports.gro-report');
    }

    public function download(Request $request)
    {
        $rules = [
            'report_type'   => ['required', Rule::in('active_business_plan', 'summary')],
            'download_type' => ['required', 'in:pdf,xls,view'],
            'ids'           => ['required', 'array'],
            'ids.*'         => ['required', 'integer', Rule::exists(JGro::getTableName(), 'id')],
            'j_project_id'  => ['required', Rule::exists(JProject::getTableName(), 'id')],
        ];
        $request->validate($rules);
        $jProject = JProject::find($request->j_project_id);
        if ('summary' == $request->report_type) {
            return $this->_summaryReport($request, $jProject);
        } elseif ('active_business_plan' == $request->report_type) {
            return $this->_activeBusinessPlanReport($request, $jProject);
        }
    }

    private function _summaryReport(Request $request, JProject $project)
    {
        $data = JGro::with([
            'families' => function ($builder1) {
                $builder1->whereRelation('family', 'status', FamilyStatus::Active)
                    ->with([
                        'family' => function ($builder2) {
                            $builder2->with([
                                'head' => function ($builder3) {
                                    $builder3->with([
                                        'details' => function ($builder4) {
                                            $builder4->with('occupation');
                                        }
                                    ]);
                                },
                                'members',
                                'familyBalance'
                            ])->select('id', 'name', 'family_head_id', 'number_of_family_member', 'need_assessment')
                                ->withSum('incomes', 'income_amount')
                                ->withSum('expenses', 'expense_amount')
                                ->where('status', FamilyStatus::Active);
                        },
                    ]);
            },
            'bank',
            'cashier',
            'leader',
            'cashier',
        ])
            ->withCount('businessPlans', 'families')
            ->withSum('j_equities', 'approved_amount')
            ->withSum('investments', 'approved_amount')
            ->withSum('savings', 'approved_amount')
            ->whereIn('id', $request->ids)->get();

        if ('pdf' == $request->download_type) {
            $file_name = "Report_gro_summary_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.gro-summary', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_gro_summary_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.gro-summary', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.gro-summary', compact('data'));
        }
    }

    private function _activeBusinessPlanReport(Request $request, JProject $project)
    {
        $data = JGro::with(['businessPlans' => function ($sql) {
            $sql->with('family', 'j_investment_approved_area')->where('status', JBusinessPlanStatus::Ongoing)->orWhere('status', JBusinessPlanStatus::Approved);
        }])->whereIn('id', $request->ids)->get();

        if ('pdf' == $request->download_type) {
            $file_name = "Report_gro_active_business_plan_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.gro-active-business-plan', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_gro_active_business_plan_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new ReportExport('dashboard.jeebika.download.gro-active-business-plan', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.gro-active-business-plan', compact('data'));
        }
    }
}
