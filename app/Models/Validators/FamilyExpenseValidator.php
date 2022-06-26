<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilyExpenseType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyExpense;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyExpenseValidator
{
    /**
     * @param FamilyExpense $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyExpense $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'expense_type' => ['required', new Enum(FamilyExpenseType::class)],
            'expense_amount' => ['required', 'numeric', 'max:10000000'],
            'expense_remarks' => ['nullable', new Name(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
