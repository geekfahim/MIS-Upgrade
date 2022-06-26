<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyDisasterLevel;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyDisaster;
use App\Models\Base\Settings\Disaster;
use App\Models\Base\Settings\Recover;
use App\Models\Validators\FamilyDisasterValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyDisasterController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'disaster_id', 'disaster_level', 'recover_id'];
        $data = FamilyDisaster::getAllByFamilyId($fid, $keys);
        return response()->json([
            'lists' => $data,
            'LEVELS' => FamilyDisasterLevel::cases(),
            'sourceDisasters' => Disaster::all(['id', 'name']),
            'sourceRecoveries' => Recover::all(['id', 'name']),
        ], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyDisaster::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyDisasterValidator())->validate($data = new FamilyDisaster(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Disaster has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyDisaster::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyDisasterValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Disaster has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyDisaster::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Disaster in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Disaster has been successfully deleted'], Response::HTTP_OK);
    }
}
