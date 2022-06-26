<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilySavingType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilySaving;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilySavingValidator
{
    /**
     * @param FamilySaving $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilySaving $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'savings_type' => ['required', new Enum(FamilySavingType::class)],
            'savings_amount' => ['required', 'numeric', 'max:10000000'],
            'savings_remarks' => ['nullable', new Name(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
