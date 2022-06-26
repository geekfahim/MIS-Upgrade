<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilyOtherNGOHelpType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyOtherNgo;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyOtherNgoValidator
{
    /**
     * @param FamilyOtherNgo $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyOtherNgo $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'ngo_name' => ['required', new Name(), 'max:51'],
            'ngo_help_type' => ['required', new Enum(FamilyOtherNGOHelpType::class)],
            'ngo_remarks' => ['nullable', new Name(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
