<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Enums\FamilyRichHelpType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\FamilyRichHelp;
use App\Models\Validators\FamilyRichHelpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FamilyRichHelpController extends Controller
{

    public function getList($fid): JsonResponse
    {
        $keys = ['id', 'rich_help_type'];
        $data = FamilyRichHelp::getAllByFamilyId($fid, $keys);
        return response()->json(['lists' => $data, 'RICH_HELP_TYPES' => FamilyRichHelpType::cases()], Response::HTTP_OK);
    }

    public function getElementById($fid, $id): JsonResponse
    {
        $data = FamilyRichHelp::where('family_id', $fid)->findOrFail($id);
        return response()->json(removeEmptyKey($data), Response::HTTP_OK);
    }

    public function create($fid): JsonResponse
    {
        $attributes = (new FamilyRichHelpValidator())->validate($data = new FamilyRichHelp(), array_merge(request()->all(), ['family_id' => $fid]));
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Rich Help has been successfully created.'], Response::HTTP_OK);
    }

    public function update($fid, $id): JsonResponse
    {
        $data = FamilyRichHelp::where('family_id', $fid)->findOrFail($id);
        $attributes = (new FamilyRichHelpValidator())->validate($data, request()->all());
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Rich Help has been successfully updated.'], Response::HTTP_OK);
    }

    public function delete($fid, $id): JsonResponse
    {
        $item = FamilyRichHelp::where('family_id', $fid)->findOrFail($id);
        if (!$item->delete()) return response()->json(['message' => 'Rich Help in used'], Response::HTTP_UNPROCESSABLE_ENTITY);
        return response()->json(['success' => 'Rich Help has been successfully deleted'], Response::HTTP_OK);
    }
}
