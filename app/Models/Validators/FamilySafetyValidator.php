<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilySafetyAbuserRelationType;
use App\Enums\FamilySafetyAbuseType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilySafety;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilySafetyValidator
{
    /**
     * @param FamilySafety $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilySafety $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'safety_victim_name' => ['required', new Name(), 'max:51'],
            'safety_relation_with_abuser' => ['required', new Enum(FamilySafetyAbuserRelationType::class)],
            'safety_type_of_abuse' => ['required', new Enum(FamilySafetyAbuseType::class)],
            'safety_place_of_abuse' => ['required', new Name(), 'max:51'],
            'safety_abuser_name' => ['required', new Name(), 'max:51'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
