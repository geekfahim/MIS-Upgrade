<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyAsset;
use App\Models\Base\Settings\Asset;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyAssetValidator
{
    /**
     * @param FamilyAsset $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyAsset $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id'      => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation'     => ['sometimes', 'required', new Enum(Evaluation::class)],
            'asset_id'       => ['required', Rule::exists(Asset::getTableName(), 'id')],
            'asset_quantity' => ['nullable', new Name(), 'max:51'],
            'asset_location' => ['nullable', new Name(), 'max:51'],
            'asset_value'    => ['required', 'numeric', 'max:10000000'],
            'asset_remarks'  => ['nullable', new Name(), 'max:999'],
            'created_by'     => ['required'],
            'updated_by'     => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
