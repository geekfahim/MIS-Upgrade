<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JMiscellaneousStatus;
use App\Models\Jeebika\IGA\JMiscellaneous;
use App\Rules\Remarks;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JMiscellaneousApproveValidator
{
    /**
     * @param JMiscellaneous $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JMiscellaneous $model, array $attributes): array
    {
        return validator($attributes, [
            'status' => ['required', new Enum(JMiscellaneousStatus::class)],
            'date' => ['required', 'date', 'max:10'],
            'approved_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks' => ['nullable', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
