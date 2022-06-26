<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JSettlementStatus;
use App\Models\Jeebika\IGA\JSettlement;
use App\Rules\Remarks;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JSettlementApproveValidator
{
    /**
     * @param JSettlement $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JSettlement $model, array $attributes): array
    {
        return validator($attributes, [
            'status' => ['required', new Enum(JSettlementStatus::class)],
            'date' => ['required', 'date', 'max:10'],
            'approved_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks' => ['nullable', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
