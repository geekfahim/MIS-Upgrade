<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JInvestmentReturnStatus;
use App\Models\Jeebika\IGA\JInvestmentReturn;
use App\Rules\Remarks;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JInvestmentReturnApproveValidator
{
    /**
     * @param JInvestmentReturn $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JInvestmentReturn $model, array $attributes): array
    {
        return validator($attributes, [
            'status' => ['required', new Enum(JInvestmentReturnStatus::class)],
            'date' => ['required', 'date', 'max:10'],
            'approved_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks' => ['nullable', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
