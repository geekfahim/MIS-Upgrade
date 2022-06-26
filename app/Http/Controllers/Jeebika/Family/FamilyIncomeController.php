<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyIncome;
use App\Models\Base\Settings\Income;
use App\Models\Validators\FamilyIncomeValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyIncomeController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'income_id', 'income_amount', 'income_remarks'];
        $data = FamilyIncome::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'sources' => Income::all(['id', 'name'])], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyIncome::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyIncomeValidator())->validate($data = new FamilyIncome(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Income has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyIncome::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyIncomeValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Income has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyIncome::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Income in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Income has been successfully deleted'], Response::HTTP_OK);
    }
}
