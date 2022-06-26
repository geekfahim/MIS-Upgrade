<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JBPFeedbackVisitBusinessStatus;
use App\Enums\IGA\JBPFeedbackVisitStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVisit;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Models\Jeebika\Validators\JBPFeedbackVisitValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BPFeedbackVisitController extends Controller
{

    public function index($gid, $bpid): Renderable
    {
        $bp = JBusinessPlan::with('j_gro')->find($bpid);
        return view('dashboard.jeebika.gro.business-plan.feedbacks.visit', compact('bp'));
    }

    public function getList(Request $request, $gid, $bpid): JsonResponse
    {
        $bp = JBusinessPlan::findOrFail($bpid);
        list($sort, $type, $query, $item) = getListValidation($request, 'created_at,status,business_status,created_by,visit_id,visit_date');
        $data = JBPFeedbackVisit::with([
            'j_business_plan:id,business_name',
            'visit_by:id,name'
        ])
            ->select(JBPFeedbackVisit::listKey())
            ->when($query, function ($builder) use ($query) {
                $builder->where('visit_date', 'LIKE', '%' . $query . '%');
            })
            ->where('j_business_plan_id', $bpid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists' => $data,
            'fieldOfficers' => JProjectFieldOfficer::getOfficersByProjectId($bp->j_project_id),
            'businessStatus' => JBPFeedbackVisitBusinessStatus::cases(),
        ], Response::HTTP_OK);
    }

    public function create($gid, $bpid): JsonResponse
    {
        $bp = JBusinessPlan::findOrFail($bpid);
        $attributes = (new JBPFeedbackVisitValidator())->validate($data = new JBPFeedbackVisit(), \request()->all());
        $attributes['j_project_id'] = $bp->j_project_id;
        $attributes['j_gro_id'] = $bp->j_gro_id;
        $attributes['j_business_plan_id'] = $bp->id;
        $attributes['status'] = JBPFeedbackVisitStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Visit has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($gid, $bpid, $id): JsonResponse
    {
        $item = JBPFeedbackVisit::with([
            'j_business_plan:id,business_name',
            'visit_by:id,name',
            'created_user:id,name'
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($item), Response::HTTP_OK);
    }

    public function update($gid, $bpid, $id): JsonResponse
    {
        $data = JBPFeedbackVisit::findOrFail($id);
        $attributes = (new JBPFeedbackVisitValidator())->validate($data, \request()->all());
        $attributes['status'] = JBPFeedbackVisitStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Visit has been successfully updated.'], Response::HTTP_OK);
    }
}
