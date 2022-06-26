<?php

namespace App\Http\Controllers\Jeebika\Mustahiq;

use App\Enums\FamilyCookingFuelType;
use App\Enums\FamilyDrinkingWaterSource;
use App\Enums\FamilyElectricityConnectivityType;
use App\Enums\FamilyHeadedByType;
use App\Enums\FamilyHouseLandType;
use App\Enums\FamilyHouseLocation;
use App\Enums\FamilyHouseType;
use App\Enums\FamilyOtherWaterSource;
use App\Enums\FamilyRelationType;
use App\Enums\FamilyToiletOwnershipType;
use App\Enums\FamilyToiletType;
use App\Http\Controllers\Controller;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Rules\Name;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class MustahiqFamilyInfoController extends Controller
{
    public function update($id): JsonResponse
    {
        $attributes = \request()->validate([
            'updated_by' => ['required'],
            //info
            'family_headed_by' => ['nullable', new Enum(FamilyHeadedByType::class)],
            'house_type' => ['nullable', new Enum(FamilyHouseType::class)],
            'house_land_type' => ['nullable', new Enum(FamilyHouseLandType::class)],
            'house_location' => ['nullable', new Enum(FamilyHouseLocation::class)],
            'drinking_water' => ['nullable', new Enum(FamilyDrinkingWaterSource::class)],
            'other_water' => ['nullable', new Enum(FamilyOtherWaterSource::class)],
            'toilet_type' => ['nullable', new Enum(FamilyToiletType::class)],
            'toilet_owner' => ['nullable', new Enum(FamilyToiletOwnershipType::class)],
            'cooking_fuel' => ['nullable', new Enum(FamilyCookingFuelType::class)],
            'electricity_connectivity' => ['nullable', new Enum(FamilyElectricityConnectivityType::class)],
            'total_room' => ['nullable', 'numeric', 'max:20'],
            'family_reference_number' => ['nullable', new Name(), 'max:50'],
            //mustahiq
            'mustahiqs' => ['required', 'array'],
            'mustahiqs.*.mustahiq_id' => ['required', Rule::exists(Mustahiq::getTableName(), 'id')],
            'mustahiqs.*.mustahiq_name' => ['required', new Name()],
            'mustahiqs.*.relation_with_family_head' => ['required', new Enum(FamilyRelationType::class)],
        ]);
        $family = Family::findOrFail($id);
        $family->fill(Arr::except($attributes, 'mustahiqs'))->save();
        return $this->_familyRelation($family, Arr::only($attributes, ['mustahiqs', 'updated_by']));
    }

    private function _familyRelation(Family $family, array $attributes): JsonResponse
    {
        $head = array_filter($attributes['mustahiqs'], function ($item) {
            return FamilyRelationType::Self->value === $item['relation_with_family_head'];
        });
        if (count($head) > 1) {
            return response()->json(["message" => "Multiple family head are selected. Please select only one family head."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!$head) {
            return response()->json(['message' => 'Family head is not selected. Please select a family head.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $existingHead = $family->members->filter(function ($item) {
            return $item->relation_with_family_head == FamilyRelationType::Self->value;
        })->first();
        $newHead = collect($attributes['mustahiqs'])->filter(function ($item) {
            return $item['relation_with_family_head'] == FamilyRelationType::Self->value;
        })->first();

        //New head or Old head
        if ($existingHead->mustahiq_id != $newHead['mustahiq_id']) {
            $family->name = $newHead['mustahiq_name'] . "'s family";
            DB::transaction(function () use ($family, $attributes, $newHead) {
                $family->save();
                foreach ($family->members as $member) {
                    $newMustahiq = collect($attributes['mustahiqs'])->filter(function ($item) use ($member) {
                        return $item['mustahiq_id'] == $member->mustahiq_id;
                    })->first();
                    $member->is_family_head = $member->mustahiq_id == $newHead['mustahiq_id'];
                    $member->relation_with_family_head = $newMustahiq['relation_with_family_head'];
                    $member->updated_by = $attributes['updated_by'];
                    $member->updated_at = now();
                    $member->save();
                }
            });
        } else {
            foreach ($family->members as $member) {
                $newMustahiq = collect($attributes['mustahiqs'])->filter(function ($item) use ($member) {
                    return $item['mustahiq_id'] == $member->mustahiq_id;
                })->first();
                $member->relation_with_family_head = $newMustahiq['relation_with_family_head'];
                $member->updated_by = $attributes['updated_by'];
                $member->updated_at = now();
                $member->save();
            }
        }
        return response()->json(['success' => 'Family info has been successfully updated.'], Response::HTTP_OK);
    }
}
