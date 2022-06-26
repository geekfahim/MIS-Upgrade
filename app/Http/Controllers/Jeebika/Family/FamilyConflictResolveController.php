<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyConflictResolveType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyConflictResolve;
use App\Models\Validators\FamilyConflictResolveValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyConflictResolveController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'conflict_resolve_type'];
        $data = FamilyConflictResolve::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'RESOLVE_TYPES' => FamilyConflictResolveType::cases()], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyConflictResolve::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyConflictResolveValidator())->validate($data = new FamilyConflictResolve(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Conflict Resolve has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyConflictResolve::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyConflictResolveValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Conflict Resolve has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyConflictResolve::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Conflict Resolve in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Conflict Resolve has been successfully deleted'], Response::HTTP_OK);
    }
}
