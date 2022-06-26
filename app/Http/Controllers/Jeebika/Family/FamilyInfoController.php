<?php

namespace App\Http\Controllers\Jeebika\Family;

use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Rules\InArrayKey;
use App\Rules\Name;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FamilyInfoController extends Controller
{
    public function update(Request $request, $fid): JsonResponse
    {
        $data = Family::findOrFail($fid);
        $attributes = $request->validate([
            'family_headed_by' => ['nullable', new InArrayKey(Family::HEADED_BY_TYPES)],
            'house_type' => ['nullable', new InArrayKey(Family::HOUSE_TYPES)],
            'house_land_type' => ['nullable', new InArrayKey(Family::HOUSE_LAND_TYPES)],
            'house_location' => ['nullable', new InArrayKey(Family::HOUSE_LOCATIONS)],
            'drinking_water' => ['nullable', new InArrayKey(Family::DRINKING_WATER_SOURCES)],
            'other_water' => ['nullable', new InArrayKey(Family::OTHER_WATER_SOURCES)],
            'toilet_type' => ['nullable', new InArrayKey(Family::TOILET_TYPES)],
            'toilet_owner' => ['nullable', new InArrayKey(Family::TOILET_OWNERSHIP_TYPES)],
            'cooking_fuel' => ['nullable', new InArrayKey(Family::COOKING_FUEL_TYPES)],
            'electricity_connectivity' => ['nullable', new InArrayKey(Family::ELECTRICITY_CONNECTIVITY_TYPES)],
            'total_room' => ['nullable', 'numeric', 'max:20'],
            'family_reference_number' => ['nullable', new Name(), 'max:50'],
            'updated_by' => ['required']
        ]);
        $data->fill($attributes)->save();
        return response()->json(['success' => 'Family info has been successfully updated.'], Response::HTTP_OK);
    }
}
