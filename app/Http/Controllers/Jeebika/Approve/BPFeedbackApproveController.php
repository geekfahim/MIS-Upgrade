<?php

namespace App\Http\Controllers\Jeebika\Approve;

use App\Enums\IGA\JBPFeedbackFinalProfitStatus;
use App\Enums\IGA\JBPFeedbackFinalStatus;
use App\Enums\IGA\JBPFeedbackVerificationStatus;
use App\Enums\IGA\JBPFeedbackVisitBusinessStatus;
use App\Enums\IGA\JBPFeedbackVisitStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackFinal;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVerification;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVisit;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Models\Jeebika\Validators\JBPFeedbackFinalApproveValidator;
use App\Models\Jeebika\Validators\JBPFeedbackVerificationApproveValidator;
use App\Models\Jeebika\Validators\JBPFeedbackVisitApproveValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class
BPFeedbackApproveController extends Controller
{
    /* Verification */
    public function indexVerification($pid)
    {
        $project = JProject::findOrFail($pid);
        return view('dashboard.jeebika.approve.bpf-verification', compact('project'));
    }

    public function getVerificationList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'created_at,j_business_plan_id,status,created_by,verified_date,verified_id');
        $data = JBPFeedbackVerification::with([
            'j_business_plan:id,business_name',
            'verified_by:id,name',
            'j_business_plan.family'
        ])
            ->when($query, function ($builder) use ($query) {
                $builder->where('total_invested_amount', 'LIKE', '%' . $query . '%');
            })
            ->where('status', '!=', JBPFeedbackVerificationStatus::Pending)
            ->where('j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'         => $data,
            'statuses'      => JBPFeedbackVerificationStatus::cases(),
            'fieldOfficers' => JProjectFieldOfficer::getOfficersByProjectId($pid),
        ], Response::HTTP_OK);
    }

    public function updateVerification($pid, $id): JsonResponse
    {
        $data = JBPFeedbackVerification::findOrFail($id);
        if (JBPFeedbackVerificationStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only Confirmed Verification can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JBPFeedbackVerificationApproveValidator)->validate($data, \request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Verification has been successfully updated.'], Response::HTTP_OK);
    }

    /* Visit */
    public function indexVisit($pid)
    {
        $project = JProject::findOrFail($pid);
        return view('dashboard.jeebika.approve.bpf-visit', compact('project'));
    }

    public function getVisitList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'created_at,status,business_status,j_business_plan_id,visit_id,created_by,visit_date');
        $b = JBusinessPlan::getTableName();
        $v = JBPFeedbackVisit::getTableName();
        $data = JBPFeedbackVisit::with('visit_by')
            ->leftJoin($b . ' as b', 'b.id', '=', $v . '.j_business_plan_id')
            ->select($v . '.id as id', $v . '.status as status', 'visit_id', 'visit_date', 'business_status', $v . '.created_at as created_at', 'remarks', 'b.id as j_business_plan_id', 'b.business_name')
            ->when($query, function ($sql) use ($query) {
                $sql->where('b.business_name', 'LIKE', '%' . $query . '%');
            })
            ->where('b.j_project_id', $pid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists'          => $data,
            'statuses'       => JBPFeedbackVisitStatus::cases(),
            'fieldOfficers'  => JProjectFieldOfficer::getOfficersByProjectId($pid),
            'businessStatus' => JBPFeedbackVisitBusinessStatus::cases(),
        ], Response::HTTP_OK);
    }

    public function updateVisit(Request $request, $pid, $id): JsonResponse
    {
        $data = JBPFeedbackVisit::findOrFail($id);
        if (JBPFeedbackVisitStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only Confirmed Visit can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JBPFeedbackVisitApproveValidator)->validate($data, $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Visit has been successfully updated.'], Response::HTTP_OK);
    }

    /* Final */
    public function indexFinal($pid)
    {
        $project = JProject::findOrFail($pid);
        return view('dashboard.jeebika.approve.bpf-final', compact('project'));
    }

    public function getFinalList(Request $request, $pid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'created_at,j_business_plan_id,profit_status,status,created_by,final_date');
        $data = JBPFeedbackFinal::with(['j_business_plan:id,business_name'])
            ->when($query, function ($builder) use ($query) {
                $builder->where('business_name', 'LIKE', '%' . $query . '%');
            })
            ->where('j_project_id', $pid)
            ->where('status', '!=', JBPFeedbackFinalStatus::Pending)
            ->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists'        => $data,
            'statuses'     => JBPFeedbackFinalStatus::cases(),
            'profitStatus' => JBPFeedbackFinalProfitStatus::cases()
        ], Response::HTTP_OK);
    }

    public function updateFinal(Request $request, $pid, $id): JsonResponse
    {
        $data = JBPFeedbackFinal::findOrFail($id);
        if (JBPFeedbackFinalStatus::Confirmed !== $data->status) {
            return response()->json(["message" => "Only Confirmed Final Feedback can be updated."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JBPFeedbackFinalApproveValidator)->validate($data, $request->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Final Feedback has been successfully updated.'], Response::HTTP_OK);
    }
}
