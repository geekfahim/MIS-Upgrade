<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyIncome;
use App\Models\Base\Settings\Income;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyIncomeValidator
{
    /**
     * @param FamilyIncome $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyIncome $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'income_id' => ['required', Rule::exists(Income::getTableName(), 'id')],
            'income_amount' => ['required', 'numeric', 'max:10000000'],
            'income_remarks' => ['nullable', new Name(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
