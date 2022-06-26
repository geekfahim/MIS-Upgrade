<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilyLoanPurposeType;
use App\Enums\FamilyLoanSourceType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyLoan;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyLoanValidator
{
    /**
     * @param FamilyLoan $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyLoan $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'loan_source' => ['required', new Enum(FamilyLoanSourceType::class)],
            'loan_source_name' => ['required', new Name(), 'max:51'],
            'loan_taking_date' => ['required', 'date', 'max:10'],
            'loan_amount' => ['required', 'numeric', 'max:10000000'],
            'loan_rate_or_extra_amount' => ['nullable', new Name(), 'max:10000000'],
            'loan_duration' => ['required', new Name(), 'max:10000000'],
            'loan_purpose' => ['required', new Enum(FamilyLoanPurposeType::class)],
            'loan_outstanding_amount' => ['required', new Name(), 'max:10000000'],
            'loan_remarks' => ['nullable', new Name(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
