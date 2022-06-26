<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JBusinessPlanStatus;
use App\Enums\IGA\JInvestmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\Business\JBusinessPlanFamily;
use App\Models\Jeebika\IGA\JInvestment;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Validators\JInvestmentValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JInvestmentController extends Controller
{
    public function index($fid): Renderable
    {
        $family = Family::findOrFail($fid);
        return view('dashboard.jeebika.family.IGA.investment', compact('family'));
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'date,confirmed_amount,approved_amount,status,created_at');
        $data = JInvestment::with('business:id,business_name')
            ->select(JInvestment::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('confirmed_amount', 'LIKE', '%' . $query . '%')
                    ->orWhere('approved_amount', 'LIKE', '%' . $query . '%');
            })
            ->where('family_id', $fid)
            ->orderBy($sort, $type)
            ->paginate($item);

        $bp = JBusinessPlan::getTableName();
        $bpf = JBusinessPlanFamily::getTableName();
        $businessPlan = JBusinessPlan::select('id', 'business_name')
            ->whereExists(function ($query) use ($bp, $bpf, $fid) {
                $query->select(\DB::raw('*'))
                    ->from($bpf)
                    ->where($bpf . '.family_id', $fid)
                    ->whereColumn($bpf . '.j_business_plan_id', $bp . '.id');
            })
            ->whereStatus(JBusinessPlanStatus::Approved)
            ->get();
        return response()->json([
            'lists'               => $data,
            'statuses'            => JInvestmentStatus::cases(),
            'businessApplication' => $businessPlan,
        ], Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new JInvestmentValidator())->validate($data = new JInvestment(), \request()->all());
        $family = Family::findOrFail($fid);
        $jeebika = Jeebika::firstWhere('family_id', $fid);
        $attributes['j_project_id'] = $jeebika->j_project_id;
        $attributes['j_gro_id'] = $jeebika->j_gro_id;
        $attributes['family_id'] = $family->id;
        $attributes['status'] = JInvestmentStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Investment has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($fid, $id)
    {
        $item = JInvestment::with([
            'project:id,name',
            'gro:id,name',
            'business:id,business_name',
            'created_user:id,name',
            'updated_user:id,name'
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($item), Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = JInvestment::findOrFail($id);
        if (JInvestmentStatus::Pending != $data->status) {
            return response()->json(["message" => "Only pending investment can be confirmed."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JInvestmentValidator())->validate($data, \request()->all());
        $attributes['status'] = JInvestmentStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Investment has been successfully confirmed.'], Response::HTTP_OK);
    }

}
