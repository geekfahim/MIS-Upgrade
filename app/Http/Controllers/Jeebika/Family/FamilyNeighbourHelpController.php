<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyNeighbourHelpType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyNeighbourHelp;
use App\Models\Validators\FamilyNeighbourHelpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyNeighbourHelpController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'neighbour_help_type'];
        $data = FamilyNeighbourHelp::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'NEIGHBOUR_HELP_TYPES' => FamilyNeighbourHelpType::cases()], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyNeighbourHelp::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyNeighbourHelpValidator())->validate($data = new FamilyNeighbourHelp(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Neighbour Help has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyNeighbourHelp::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyNeighbourHelpValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Neighbour Help has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyNeighbourHelp::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Neighbour Help in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Neighbour Help has been successfully deleted'], Response::HTTP_OK);
    }
}
