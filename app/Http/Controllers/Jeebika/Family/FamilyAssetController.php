<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyAsset;
use App\Models\Base\Settings\Asset;
use App\Models\Validators\FamilyAssetValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use function request;

class FamilyAssetController extends Controller
{
    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'asset_id', 'asset_quantity', 'asset_location', 'asset_value', 'asset_remarks'];
        $data = FamilyAsset::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'asset_types' => Asset::getAll(['id', 'name'])], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyAsset::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyAssetValidator())->validate($data = new FamilyAsset(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Asset has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyAsset::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyAssetValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Asset has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyAsset::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Asset in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Asset has been successfully deleted'], Response::HTTP_OK);
    }
}
