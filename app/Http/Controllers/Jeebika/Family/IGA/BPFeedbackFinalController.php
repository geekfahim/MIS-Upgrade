<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JBPFeedbackFinalProfitStatus;
use App\Enums\IGA\JBPFeedbackFinalStatus;
use App\Http\Controllers\Controller;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackFinal;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\Validators\JBPFeedbackFinalValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BPFeedbackFinalController extends Controller
{

    public function index($gid, $bpid): Renderable
    {
        $bp = JBusinessPlan::with('j_gro')->find($bpid);
        return view('dashboard.jeebika.gro.business-plan.feedbacks.final', compact('bp'));
    }

    public function getList(Request $request, $gid, $bpid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'created_at,status,profit_status,total_investment,total_return,created_by,final_date');
        $data = JBPFeedbackFinal::select(JBPFeedbackFinal::listKey())
            ->when($query, function ($builder) use ($query) {
                $builder->where('total_investment', 'LIKE', '%' . $query . '%');
            })
            ->where('j_business_plan_id', $bpid)
            ->orderBy($sort, $type)->paginate($item);

        return response()->json([
            'lists' => $data,
            'profitStatus' => JBPFeedbackFinalProfitStatus::cases(),
        ], Response::HTTP_OK);
    }

    public function create($gid, $bpid): JsonResponse
    {
        $bp = JBusinessPlan::findOrFail($bpid);
        $attributes = (new JBPFeedbackFinalValidator())->validate($data = new JBPFeedbackFinal(), \request()->all());
        $attributes['j_project_id'] = $bp->j_project_id;
        $attributes['j_gro_id'] = $bp->j_gro_id;
        $attributes['j_business_plan_id'] = $bp->id;
        $attributes['status'] = JBPFeedbackFinalStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Final Feedback has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($gid, $bpid, $id): JsonResponse
    {
        $item = JBPFeedbackFinal::with([
            'j_business_plan:id,business_name',
            'created_user:id,name'
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($item), Response::HTTP_OK);
    }

    public function update($gid, $bpid, $id): JsonResponse
    {
        $data = JBPFeedbackFinal::findOrFail($id);
        $attributes = (new JBPFeedbackFinalValidator())->validate($data, \request()->all());
        $attributes['status'] = JBPFeedbackFinalStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Final Feedback has been successfully updated.'], Response::HTTP_OK);
    }
}
