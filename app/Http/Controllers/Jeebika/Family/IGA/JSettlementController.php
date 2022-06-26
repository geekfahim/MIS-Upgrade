<?php

namespace App\Http\Controllers\Jeebika\Family\IGA;

use App\Enums\IGA\JSettlementStatus;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\JSettlement;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\Validators\JSettlementValidator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JSettlementController extends Controller
{
    public function index($fid): Renderable
    {
        $family = Family::findOrFail($fid);
        return view('dashboard.jeebika.family.IGA.settlement', compact('family'));
    }

    public function getList(Request $request, $fid): JsonResponse
    {
        list($sort, $type, $query, $item) = getListValidation($request, 'date,confirmed_amount,approved_amount,status,created_at');
        $data = JSettlement::select(JSettlement::listKey())
            ->when($query, function ($sql) use ($query) {
                $sql->where('confirmed_amount', 'LIKE', '%' . $query . '%');
            })
            ->where('family_id', $fid)->orderBy($sort, $type)->paginate($item);
        return response()->json([
            'lists' => $data,
            'statuses' => JSettlementStatus::cases()
        ], Response::HTTP_OK);
    }

    public function create(Request $request, $fid): JsonResponse
    {
        $attributes = (new JSettlementValidator())->validate($data = new JSettlement(), \request()->all());
        $family = Family::findOrFail($fid);
        $jeebika = Jeebika::firstWhere('family_id', $fid);
        $attributes['j_project_id'] = $jeebika->j_project_id;
        $attributes['j_gro_id'] = $jeebika->j_gro_id;
        $attributes['family_id'] = $family->id;
        $attributes['status'] = JSettlementStatus::Pending;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Settlement has been successfully created.'], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = JSettlement::with([
            'project:id,name',
            'gro:id,name',
            'created_user:id,name',
            'updated_user:id,name',
        ])->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = JSettlement::findOrFail($id);
        if (JSettlementStatus::Pending != $data->status) {
            return response()->json(["message" => "Only pending Settlement can be confirmed."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $attributes = (new JSettlementValidator())->validate($data, \request()->all());
        $attributes['status'] = JSettlementStatus::Confirmed;
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Settlement has been successfully confirmed.'], Response::HTTP_OK);
    }
}
