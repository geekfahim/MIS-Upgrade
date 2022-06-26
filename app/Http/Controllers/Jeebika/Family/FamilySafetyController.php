<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilySafetyAbuserRelationType;
use App\Enums\FamilySafetyAbuseType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilySafety;
use App\Models\Validators\FamilySafetyValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilySafetyController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'safety_victim_name', 'safety_relation_with_abuser', 'safety_type_of_abuse', 'safety_place_of_abuse', 'safety_abuser_name'];
        $data = FamilySafety::getAllByFamilyId($fid, $keys);
        return response()->json([
            'lists' => $data,
            'ABUSER_RELATION_TYPES' => FamilySafetyAbuserRelationType::cases(),
            'ABUSE_TYPES' => FamilySafetyAbuseType::cases()
        ], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilySafety::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilySafetyValidator())->validate($data = new FamilySafety(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Safety has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilySafety::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilySafetyValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Safety has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilySafety::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Safety in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Safety has been successfully deleted'], Response::HTTP_OK);
    }
}
