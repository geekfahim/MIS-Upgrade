<?php

namespace App\Http\Controllers\Jeebika\Reports;

use App\Enums\FamilyStatus;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Enums\IGA\JSavingStatus;
use App\Enums\JImplementationPlanStatus;
use App\Enums\JTrainingType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyMember;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\JSaving;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Project\JImplementationPlan;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JIndicator;
use App\Models\Jeebika\Training\JTraining;
use App\Models\Jeebika\Training\JTrainingMustahiq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.jeebika.reports.statistic');
    }

    public function getAll(Request $request): JsonResponse
    {
        $request->validate([
            "j_project_id" => ['nullable', 'numeric', Rule::exists(JProject::class, 'id')],
            "from_date"    => Rule::when($request->filled('to_date'), ['required', 'date', 'max:10', 'before_or_equal:to_date']),
            "to_date"      => Rule::when($request->filled('from_date'), ['required', 'date', 'max:10', 'after_or_equal:from_date'])
        ]);

        $projectId = $request->input("j_project_id") ?? null;
        $from_date = $request->input("from_date") ?? null;
        $to_date = $request->input("to_date") ?? null;

        $f = Family::getTableName();
        $j = Jeebika::getTableName();
        $js = JSaving::getTableName();
        $familyStatus = FamilyStatus::Active->value;

        //total family validate and need
        $data = Family::select(DB::raw(
            "COUNT(CASE WHEN status='{$familyStatus}' THEN 1 END) AS validate,
            COUNT(CASE WHEN need_assessment='1' THEN 1 END) AS need"
        ))
            ->join($j . ' as j', 'j.family_id', '=', $f . '.id')
            ->when($projectId, function ($builder) use ($projectId) {
                $builder->where('j.j_project_id', '=', $projectId);
            })
            ->when($from_date && $to_date, function ($builder) use ($f, $from_date, $to_date) {
                $builder->whereBetween($f . '.created_at', [$from_date, $to_date]);
            })
            ->first();

        $savingFamily = Family::join($js . ' as js', 'js.family_id', '=', $f . '.id')
            ->when($projectId, function ($builder) use ($projectId) {
                $builder->where('js.j_project_id', '=', $projectId);
            })
            ->when($from_date && $to_date, function ($builder) use ($f, $from_date, $to_date) {
                $builder->whereBetween($f . '.updated_by', [$from_date, $to_date]);
            })
            ->where('js.status', JSavingStatus::Approved)
            ->distinct('js.family_id')
            ->count();

        //total family skill trainings
        $m = FamilyMember::getTableName();
        $t = JTraining::getTableName();
        $tm = JTrainingMustahiq::getTableName();
        $skill = Family::select($f . '.id as id', 'name')
            ->join($m . ' as m', 'm.family_id', '=', $f . '.id')
            ->join($tm . ' as tm', 'tm.mustahiq_id', '=', 'm.mustahiq_id')
            ->join($t . ' as t', 't.id', '=', 'tm.j_training_id')
            ->when($projectId, function ($builder) use ($projectId) {
                $builder->where('j_project_id', $projectId);
            })
            ->when($from_date && $to_date, function ($builder) use ($from_date, $to_date) {
                $builder->whereBetween('t.created_at', [$from_date, $to_date]);
            })
            ->distinct($f . '.id')
            ->where('is_present', 1)
            ->where('training_type', JTrainingType::Skill)
            ->count();

        $savings = JSaving::when($projectId, function ($builder) use ($projectId) {
            $builder->where('j_project_id', $projectId);
        })
            ->when($from_date && $to_date, function ($builder) use ($from_date, $to_date) {
                $builder->whereBetween('created_at', [$from_date, $to_date]);
            })
            ->sum('approved_amount');

        $approveBusinessPlan = JBusinessPlan::where(function ($builder) {
            $builder->where('status', JBusinessPlanStatus::Approved)->orWhere('status', JBusinessPlanStatus::Ongoing);
        })
            ->when($projectId, function ($builder) use ($projectId) {
                $builder->where('j_project_id', $projectId);
            })
            ->when($from_date && $to_date, function ($builder) use ($from_date, $to_date) {
                $builder->whereBetween('created_at', [$from_date, $to_date]);
            })
            ->count();

        $vocational = JTrainingMustahiq::join($t . ' as t', 't.id', '=', $tm . '.j_training_id')
            ->when($projectId, function ($builder) use ($projectId) {
                $builder->where('j_project_id', $projectId);
            })
            ->when($from_date && $to_date, function ($builder) use ($tm, $from_date, $to_date) {
                $builder->whereBetween($tm . '.updated_at', [$from_date, $to_date]);
            })
            ->where('is_present', 1)
            ->where('training_type', JTrainingType::Vocational)
            ->count();

        $i = JIndicator::getTableName();
        $ip = JImplementationPlan::getTableName();
        $ipStatusPending = JImplementationPlanStatus::Pending->value;
        $ipStatusImplemented = JImplementationPlanStatus::Implemented->value;
        $from_date = $from_date ?? getDefaultFromDate();
        $to_date = $to_date ?? getDefaultToDate();
//        $indicators = JIndicator::join($ip . ' as ip', 'ip.j_indicator_id', '=', $i . '.id')->get();
//        dd($indicators);
        $indicators = JIndicator::join($ip . ' as ip', 'ip.j_indicator_id', '=', $i . '.id')
            ->selectRaw("
            j_indicator_id as id,
            name,
            j_project_id,
            COUNT(*) AS total,
            COUNT(CASE WHEN possible_implementation_date BETWEEN '{$from_date}' AND '{$to_date}' THEN 1 END) AS target,
            COUNT(CASE WHEN implement_status='{$ipStatusImplemented}' AND possible_implementation_date BETWEEN '{$from_date}' AND '{$to_date}' THEN 1 END) AS achievement
            ")
            ->groupBy('name', 'j_project_id', 'j_indicator_id')
            ->when($projectId, function ($builder) use ($projectId) {
                $builder->where('j_project_id', $projectId);
            })
            ->get();
        return response()->json([
            'lists'               => $data,
            'savingFamily'        => $savingFamily,
            'validateFamily'      => $data->validate,
            'needFamily'          => $data->need,
            'indicators'          => $indicators,
            'skillFamily'         => $skill,
            'vocationalMustahiq'  => $vocational,
            'approveBusinessPlan' => $approveBusinessPlan,
            'savings'             => $savings,
            'allProjects'         => JProject::getAll(['id', 'name']),
            'statuses'            => JImplementationPlanStatus::cases()
        ], Response::HTTP_OK);

    }
}
