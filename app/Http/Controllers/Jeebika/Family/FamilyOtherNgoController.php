<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyOtherNGOHelpType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyOtherNgo;
use App\Models\Validators\FamilyOtherNgoValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyOtherNgoController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'ngo_name', 'ngo_help_type', 'ngo_remarks'];
        $data = FamilyOtherNgo::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'HELP_TYPES' => FamilyOtherNGOHelpType::cases()], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyOtherNgo::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyOtherNgoValidator())->validate($data = new FamilyOtherNgo(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'NGO has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyOtherNgo::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyOtherNgoValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'NGO has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyOtherNgo::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'NGO in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'NGO has been successfully deleted'], Response::HTTP_OK);
    }
}
