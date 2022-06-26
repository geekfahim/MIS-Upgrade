<?php

namespace App\Http\Controllers\Jeebika\Reports;

use App\Enums\FamilyStatus;
use App\Enums\IGA\JBankChargeStatus;
use App\Enums\IGA\JMiscellaneousStatus;
use App\Enums\IGA\JSavingStatus;
use App\Enums\IGA\JEquityStatus;
use App\Enums\IGA\JSettlementStatus;
use App\Enums\IGA\JWithdrawlStatus;
use App\Exports\JeebikaFamilyMultipleExcelReport;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class FamilyReportController extends Controller
{
    public function index(): Renderable
    {
        return view('dashboard.jeebika.reports.family-report');
    }

    public function download(Request $request)
    {
        $dateReportTypes = ['savings', 'equity', 'bank_charge', 'miscellaneous', 'settlement', 'withdrawal'];
        $rules = [
            'report_type'   => ['required', Rule::in(array_merge(['full', 'summary', 'extended'], $dateReportTypes))],
            'download_type' => ['required', 'in:pdf,xls,view'],
            'ids'           => ['required', 'array'],
            'ids.*'         => ['required', 'integer', Rule::exists(Family::getTableName(), 'id')],
            'j_project_id'  => ['required', Rule::exists(JProject::getTableName(), 'id')],
            'j_gro_id'      => ['required', Rule::exists(JGro::getTableName(), 'id')],
        ];
        if (in_array($request->report_type, $dateReportTypes)) {
            $rules['from_date'] = ['required', 'date'];
            $rules['to_date'] = ['required', 'date', 'after:from_date'];
        }
        $request->validate($rules);

        $jProject = JProject::find($request->j_project_id);
        $jGro = JGro::find($request->j_gro_id);

        if ('summary' == $request->report_type) {
            return $this->_summaryReport($request, $jProject, $jGro);
        } elseif ('full' == $request->report_type) {
            return $this->_fullReport($request, $jProject, $jGro);
        } elseif ('extended' == $request->report_type) {
            return $this->_summaryReport($request, $jProject, $jGro);
        } elseif ('savings' == $request->report_type) {
            return $this->_savingsReport($request, $jProject, $jGro);
        } elseif ('equity' == $request->report_type) {
            return $this->_seedFundReport($request, $jProject, $jGro);
        } elseif ('bank_charge' == $request->report_type) {
            return $this->_bankChargeReport($request, $jProject, $jGro);
        } elseif ('miscellaneous' == $request->report_type) {
            return $this->_miscellaneousReport($request, $jProject, $jGro);
        } elseif ('withdrawal' == $request->report_type) {
            return $this->_withdrawalReport($request, $jProject, $jGro);
        } elseif ('settlement' == $request->report_type) {
            return $this->_settlementReport($request, $jProject, $jGro);
        }
    }

    private function _summaryReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with([
            'members' => function ($builder) {
                $builder->with(['mustahiq' => function ($builder) {
                    $builder->with(['details' => function ($builder) {
                        $builder->select('mustahiq_id', 'occupation_id', 'highest_education_level', 'is_earn_ability');
                    }])->select('id', 'name', 'birth_date', 'nid', 'mobile', 'disability_id');
                }])->select('id', 'family_id', 'mustahiq_id', 'is_family_head', 'relation_with_family_head');
            },
            'head.resource',
            'assets.asset',
        ])
            ->whereStatus(FamilyStatus::Active)
            ->withCount(['assets' => function ($query) {
                $query->select(DB::raw('sum(asset_value)'));
            }])->withCount(['loans' => function ($query) {
                $query->select(DB::raw('sum(loan_outstanding_amount)'));
            }])->withCount(['expenses' => function ($query) {
                $query->select(DB::raw('sum(expense_amount)'));
            }])->withCount(['incomes' => function ($query) {
                $query->select(DB::raw('sum(income_amount)'));
            }])->withCount(['savings' => function ($query) {
                $query->select(DB::raw('sum(savings_amount)'));
            }])->withCount(['neighbourHelps', 'richHelps', 'otherNgos', 'safeties', 'disasters', 'conflictResolves'])
            ->whereIn('id', $request->ids)
            ->get();

        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_summary_" . now()->format('Ymd_Hi') . '.pdf';
//            $html = '<h1>dashboard.jeebika.download.pdf.family-summary</h1>';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-summary', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_summary_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-summary', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-summary', compact('data'));
        }
    }

    private function _fullReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with([
            'members' => function ($builder) {
                $builder->with(['mustahiq' => function ($builder) {
                    $builder->with(['details' => function ($builder) {
                        $builder->select('mustahiq_id', 'occupation_id', 'highest_education_level', 'is_earn_ability');
                    }])->select('id', 'name', 'birth_date', 'nid', 'mobile', 'disability_id');
                }])->select('id', 'family_id', 'mustahiq_id', 'is_family_head', 'relation_with_family_head');
            },
            'head:id,name,mobile,nid',
            'head.resource',
            'assets.asset',
            'loans:id,family_id,loan_taking_date,loan_source_name,loan_amount,loan_rate_or_extra_amount,loan_duration,loan_purpose,loan_outstanding_amount',
            'expenses:id,family_id,expense_type,expense_amount',
            'savings:id,family_id,savings_type,savings_amount',
            'incomes.income:id,name',
            'otherNgos:id,family_id,ngo_name,ngo_help_type',
            'safeties:id,family_id,safety_victim_name,safety_relation_with_abuser,safety_type_of_abuse,safety_place_of_abuse,safety_abuser_name',
            'neighbourHelps:id,family_id,neighbour_help_type',
            'richHelps:id,family_id,rich_help_type',
            'conflictResolves:id,family_id,conflict_resolve_type',
            'disasters.disaster',
        ])->whereIn('id', $request->ids)->get();

        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_full_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-full', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_full_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-full', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-full', compact('data'));
        }
    }

    private function _savingsReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with([
            'j_savings' => function ($builder) use ($request) {
                $builder->with('collector:id,name')
                    ->select('id', 'family_id', 'date', 'confirmed_amount', 'approved_amount', 'collector_id', 'remarks')
                    ->whereStatus(JSavingStatus::Approved)
                    ->whereBetween('date', [$request->from_date, $request->to_date]);
            }])->whereIn('id', $request->ids)->get();

        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date,
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_savings_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-savings', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_savings_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-savings', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-savings', compact('data'));
        }
    }

    private function _seedFundReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with(['j_equity' => function ($builder) use ($request) {
            $builder->select('id', 'family_id', 'date', 'confirmed_amount', 'approved_amount', 'remarks')
                ->whereStatus(JEquityStatus::Approved)
                ->whereBetween('date', [$request->from_date, $request->to_date]);
        }])->whereIn('id', $request->ids)->get();

        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_equity_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-seed-fund', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_$family_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-seed-fund', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-seed-fund', compact('data'));
        }
    }

    private function _bankChargeReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with(['j_bank_charge' => function ($builder) use ($request) {
            $builder->select('id', 'family_id', 'date', 'confirmed_amount', 'approved_amount', 'remarks')
                ->whereStatus(JBankChargeStatus::Approved)
                ->whereBetween('date', [$request->from_date, $request->to_date]);
        }])->whereIn('id', $request->ids)->get();

        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_bank_charge_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-bank-charge', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_bank_charge_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-bank-charge', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-bank-charge', compact('data'));
        }
    }

    private function _miscellaneousReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with(['j_miscellaneous' => function ($builder) use ($request) {
            $builder->select('id', 'family_id', 'date', 'confirmed_amount', 'approved_amount', 'remarks')
                ->whereStatus(JMiscellaneousStatus::Approved)
                ->whereBetween('date', [$request->from_date, $request->to_date]);
        }])->whereIn('id', $request->ids)->get();
        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_miscellaneous_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-miscellaneous', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_miscellaneous_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-miscellaneous', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-miscellaneous', compact('data'));
        }
    }

    private function _withdrawalReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with(['j_withdrawal' => function ($builder) use ($request) {
            $builder->select('id', 'family_id', 'date', 'confirmed_amount', 'approved_amount', 'remarks')
                ->whereStatus(JWithdrawlStatus::Approved)
                ->whereBetween('date', [$request->from_date, $request->to_date]);
        }])->whereIn('id', $request->ids)->get();

        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_withdrawal_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-withdrawal', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_withdrawal_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-withdrawal', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-withdrawal', compact('data'));
        }
    }

    private function _settlementReport(Request $request, JProject $project, JGro $gro)
    {
        $families = Family::with(['j_settlement' => function ($builder) use ($request) {
            $builder->select('id', 'family_id', 'date', 'confirmed_amount', 'approved_amount', 'remarks')
                ->whereStatus(JSettlementStatus::Approved)
                ->whereBetween('date', [$request->from_date, $request->to_date]);
        }])->whereIn('id', $request->ids)->get();

        $data = [
            'families'     => $families,
            'project_name' => $project->name,
            'gro'          => $gro,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date
        ];

        if ('pdf' == $request->download_type) {
            $file_name = "Report_family_settlement_" . now()->format('Ymd_Hi') . '.pdf';
            $pdf = PDF::loadView('dashboard.jeebika.download.pdf.family-settlement', compact('data'))->setOptions(getPDFOptions())->setOption('orientation', 'landscape');
            return $pdf->download($file_name)->header('file_name', $file_name);
        }
        if ('xls' == $request->download_type) {
            $file_name = "Report_family_settlement_" . now()->format('Ymd_Hi') . '.xlsx';
            return Excel::download(new JeebikaFamilyMultipleExcelReport('dashboard.jeebika.download.xl.family-settlement', $data), $file_name, null, ['file_name' => $file_name]);
        }
        if ('view' == $request->download_type) {
            return view('dashboard.jeebika.download.pdf.family-settlement', compact('data'));
        }
    }
}
