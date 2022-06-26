<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilyDisasterLevel;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyDisaster;
use App\Models\Base\Settings\Disaster;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyDisasterValidator
{
    /**
     * @param FamilyDisaster $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyDisaster $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'disaster_id' => ['required', Rule::exists(Disaster::getTableName(), 'id')],
            'disaster_level' => ['required', new Enum(FamilyDisasterLevel::class)],
            'recover_id' => ['required', Rule::exists(Disaster::getTableName(), 'id')],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
