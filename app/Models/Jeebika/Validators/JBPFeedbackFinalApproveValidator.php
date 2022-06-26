<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JBPFeedbackFinalProfitStatus;
use App\Enums\IGA\JBPFeedbackFinalStatus;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackFinal;
use App\Rules\Remarks;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JBPFeedbackFinalApproveValidator
{
    /**
     * @param JBPFeedbackFinal $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JBPFeedbackFinal $model, array $attributes): array
    {
        return validator($attributes, [
            'status' => ['required', new Enum(JBPFeedbackFinalStatus::class)],
            'is_investment_as_per_application' => ['required', 'integer', 'in:0,1'],
            'is_recommended' => ['required', 'integer', 'in:0,1'],
            'total_investment' => ['required', 'integer', 'digits_between:2,6'],
            'total_return' => ['required', 'integer', 'digits_between:2,6'],
            'business_tenure' => ['required', 'integer', 'digits_between:1,6'],
            'final_date' => ['required', 'date', 'max:10'],
            'investment_findings' => ['nullable', 'min:2', new Remarks(), 'max:999'],
            'profit_status' => ['required', new Enum(JBPFeedbackFinalProfitStatus::class)],
            'remarks' => ['nullable', 'min:2', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
