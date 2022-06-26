<?php

namespace App\Http\Controllers\Jeebika\Project;

use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\JNeed;
use App\Models\Jeebika\JNeedAnalysis;
use App\Models\Jeebika\Project\JImplementationPlan;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JIndicator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ImplementationPlanCreateController extends Controller
{
    public function index($pid): Renderable
    {
        $project = JProject::find($pid);
        $i = JIndicator::getTableName();
        $a = JNeedAnalysis::me();
        $project->programs = JNeedAnalysis::leftJoin($i . ' as i', 'i.id', '=', $a . '.j_indicator_id')
            ->select($a . '.id as id', 'j_project_id', 'j_gro_id', 'j_indicator_id', 'total_need', 'name', 'type', 'sequence', 'program_type', 'status')
            ->where('j_project_id', $project->id)
            ->get()
            ->groupBy('program_type');
        return view('dashboard.jeebika.project.implementation-plan-create', compact('project'));
    }

    public function getNeedListByIndicatorId($pid): JsonResponse
    {
        request()->validate([
            "j_gro_id" => ['required', Rule::exists(JGro::getTableName(), 'id')],
            "j_indicator_id" => ['required', Rule::exists(JIndicator::getTableName(), 'id')]
        ]);

        $jProject = JProject::findOrFail($pid);
        $jGro = JGro::find(request()->input("j_gro_id"));
        $jIndicator = JIndicator::find(request()->input("j_indicator_id"));
        $familyIds = Jeebika::where('j_project_id', $jProject->id)->where('j_gro_id', $jGro->id)->pluck('family_id');

        $data = JNeed::with([
            'family:id,name',
            'member:id,name',
            'j_indicator:id,name'
        ])->select('family_id', 'member_id', 'j_indicator_id', 'is_need', 'is_implementation')
            ->where('is_need', true)
            ->where('j_indicator_id', $jIndicator->id)
            ->whereIn('family_id', $familyIds)
            ->get();
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($pid): JsonResponse
    {
        request()->validate([
            'ids' => 'required|array',
            'ids.*' => 'string',
            'dates' => 'required|array',
            'dates.*' => 'date'
        ]);

        $jIndicators = JIndicator::getAll(['id', 'name']);
        $jeebikas = Jeebika::get();
        $jGros = JGro::select('id', 'name')->get();
        $families = Family::select('id', 'name')->get();
        $mustahiqs = Mustahiq::select('id', 'name')->get();
        $jProject = JProject::select('id', 'name')->findOrFail($pid);
        $multipleIds = request('ids');
        $dates = request('dates');

        foreach ($multipleIds as $singleIds) {
            list ($jIndicator_id, $family_id, $member_id) = explode('_', $singleIds);
            $jIndicator = $jIndicators->firstWhere('id', $jIndicator_id);
            $family = $families->firstWhere('id', $family_id);
            $member = $member_id != 'null' ? $mustahiqs->firstWhere('id', $member_id) : null;
            $jeebika = $jeebikas->where('j_project_id', $jProject->id)->where('family_id', $family->id)->first();
            $jGro = $jGros->firstWhere('id', $jeebika->j_gro_id);
            $jImplementationPlans = JImplementationPlan::where('j_project_id', $jProject->id)->where('j_gro_id', $jGro->id)->where('j_indicator_id', $jIndicator->id)->get();
            $jNeed = JNeed::select('id', 'family_id', 'member_id', 'j_indicator_id', 'is_need', 'is_implementation')->where('j_indicator_id', $jIndicator->id)->where('family_id', $family->id)->where('is_need', true)
                ->when($member, function ($builder) use ($member) {
                    $builder->where('member_id', $member->id);
                }, function ($builder) {
                    $builder->where('member_id', null);
                })->first();

            if (!$jNeed) {
                return response()->json(['message' => 'Need not found. Please contact with the administrator.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            //if exist then continue
            if (($member && $jImplementationPlans->where('family_id', $family->id)->where('member_id', $member->id)->first()) ||
                $jImplementationPlans->where('family_id', $family->id)->where('member_id', null)->first()) {
                continue;
            }

            foreach ($dates as $date) {
                $data = [
                    'j_project_id' => $jProject->id,
                    'j_gro_id' => $jGro->id,
                    'j_indicator_id' => $jIndicator->id,
                    'family_id' => $family->id,
                    'possible_implementation_date' => $date,
                    'created_by' => request('created_by'),
                    'created_at' => now()
                ];
                if ($member) {
                    $data['member_id'] = $member->id;
                }
                JImplementationPlan::create($data);
            }
            $jNeed->is_implementation = true;
            $jNeed->updated_by = request('updated_by');
            $jNeed->updated_at = now();
            $jNeed->save();
        }
        return response()->json(['success' => 'Implementation plan has been successfully created.'], Response::HTTP_OK);
    }
}
