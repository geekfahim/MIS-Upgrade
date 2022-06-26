<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JBankChargeStatus;
use App\Models\Jeebika\IGA\JBankCharge;
use App\Rules\Remarks;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JBankChargeApproveValidator
{
    /**
     * @param JBankCharge $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JBankCharge $model, array $attributes): array
    {
        return validator($attributes, [
            'status'          => ['required', new Enum(JBankChargeStatus::class)],
            'date'            => ['required', 'date', 'max:10'],
            'approved_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks'         => ['nullable', new Remarks(), 'max:999'],
            'updated_by'      => ['required'],
        ])->validate();

    }
}
