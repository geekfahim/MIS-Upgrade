<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JBPFeedbackVerificationStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVerification;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Models\Jeebika\Validators\JBPFeedbackVerificationValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BPFeedbackVerificationController extends Controller
{

    public function index($gid, $bpid): Renderable
    {
        $bp = JBusinessPlan::with('j_gro')->find($bpid);
        return view('dashboard.jeebika.gro.business-plan.feedbacks.verification', compact('bp'));
    }

    public function getList(Request $request, $gid, $bpid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'created_at,status,created_by,verified_date,verified_id,total_invested_amount');
        $bp = JBusinessPlan::findOrFail($bpid);
        $data = JBPFeedbackVerification::with(['j_business_plan:id,business_name', 'verified_by:id,name', 'j_business_plan.family'])
            ->select(JBPFeedbackVerification::listKey())
            ->when($query, function ($builder) use ($query) {
                $builder->where('total_invested_amount', 'LIKE', '%' . $query . '%');
            })
            ->where('j_business_plan_id', $bpid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists' => $data,
            'statuses' => JBPFeedbackVerificationStatus::cases(),
            'fieldOfficers' => JProjectFieldOfficer::getOfficersByProjectId($bp->j_project_id),
        ], Response::HTTP_OK);
    }

    public function create($gid, $bpid): JsonResponse
    {
        $bp = JBusinessPlan::findOrFail($bpid);
        $attributes = (new JBPFeedbackVerificationValidator())->validate($data = new JBPFeedbackVerification(), \request()->all());
        $attributes['j_project_id'] = $bp->j_project_id;
        $attributes['j_gro_id'] = $bp->j_gro_id;
        $attributes['j_business_plan_id'] = $bp->id;
        $attributes['status'] = JBPFeedbackVerificationStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Verification has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($gid, $bpid, $id): JsonResponse
    {
        $item = JBPFeedbackVerification::with([
            'j_business_plan:id,business_name',
            'verified_by:id,name',
            'created_user:id,name'
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($item), Response::HTTP_OK);
    }

    public function update($gid, $bpid, $id): JsonResponse
    {
        $data = JBPFeedbackVerification::findOrFail($id);
        $attributes = (new JBPFeedbackVerificationValidator())->validate($data, \request()->all());
        $attributes['status'] = JBPFeedbackVerificationStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Verification has been successfully updated.'], Response::HTTP_OK);
    }
}
