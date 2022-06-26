<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JInvestmentStatus;
use App\Models\Jeebika\IGA\JInvestment;
use App\Rules\Remarks;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JInvestmentApproveValidator
{
    /**
     * @param JInvestment $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JInvestment $model, array $attributes): array
    {
        return validator($attributes, [
            'status' => ['required', new Enum(JInvestmentStatus::class)],
            'date' => ['required', 'date', 'max:10'],
            'approved_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks' => ['nullable', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
