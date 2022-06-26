<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JBusinessPlanStatus;
use App\Enums\IGA\JInvestmentReturnStatus;
use App\Enums\IGA\JInvestmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\JInvestment;
use App\Models\Jeebika\IGA\JInvestmentReturn;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Models\Jeebika\Validators\JInvestmentReturnValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JInvestmentReturnController extends Controller
{
    public function index($fid): Renderable
    {
        $family = Family::findOrFail($fid);
        return view('dashboard.jeebika.family.IGA.investment-return', compact('family'));
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        $projectId = Jeebika::firstWhere('family_id', $fid);
        list($sort, $type, $query, $item) = getListValidation($request, 'date,confirmed_amount,j_business_plan_id,status,approved_amount,created_at');
        $data = JInvestmentReturn::with('business:id,business_name')->select(JInvestmentReturn::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('confirmed_amount', 'LIKE', '%' . $query . '%');
            })
            ->where('family_id', $fid)->orderBy($sort, $type)->paginate($item);

        $investmentBPIds = JInvestment::where('family_id', $fid)->whereStatus(JInvestmentStatus::Approved)->pluck('j_business_plan_id');
        $businessPlan = JBusinessPlan::select('id', 'business_name', 'status')->whereIn('id', $investmentBPIds)->whereStatus(JBusinessPlanStatus::Approved)->get();
        return response()->json([
            'lists'              => $data,
            'statuses'           => JInvestmentReturnStatus::cases(),
            'businessInvestment' => $businessPlan,
            'fieldOfficers'      => JProjectFieldOfficer::getOfficersByProjectId($projectId->j_project_id),
        ], Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new JInvestmentReturnValidator())->validate($data = new JInvestmentReturn(), \request()->all());
        $family = Family::findOrFail($fid);
        $jeebika = Jeebika::firstWhere('family_id', $fid);
        $attributes['j_project_id'] = $jeebika->j_project_id;
        $attributes['j_gro_id'] = $jeebika->j_gro_id;
        $attributes['family_id'] = $family->id;
        $attributes['status'] = JInvestmentReturnStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Investment return has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = JInvestmentReturn::with([
            'project:id,name',
            'gro:id,name',
            'business:id,business_name',
            'created_user:id,name',
            'updated_user:id,name',
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = JInvestmentReturn::findOrFail($id);
        if (JInvestmentReturnStatus::Pending != $data->status) {
            return response()->json(["message" => "Only pending investment return can be confirmed."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JInvestmentReturnValidator())->validate($data, \request()->all());
        $attributes['status'] = JInvestmentReturnStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Investment Return has been successfully confirmed.'], Response::HTTP_OK);
    }
}
