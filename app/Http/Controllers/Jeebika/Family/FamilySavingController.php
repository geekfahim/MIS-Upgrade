<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilySavingType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilySaving;
use App\Models\Validators\FamilySavingValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilySavingController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'savings_type', 'savings_amount', 'savings_remarks'];
        $data = FamilySaving::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'SAVINGS_TYPES' => FamilySavingType::cases()], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilySaving::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilySavingValidator())->validate($data = new FamilySaving(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Saving has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilySaving::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilySavingValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Saving has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilySaving::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Saving in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Saving has been successfully deleted'], Response::HTTP_OK);
    }
}
