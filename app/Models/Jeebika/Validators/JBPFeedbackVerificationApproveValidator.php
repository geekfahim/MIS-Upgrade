<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JBPFeedbackVerificationStatus;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVerification;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Rules\Remarks;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JBPFeedbackVerificationApproveValidator
{
    /**
     * @param JBPFeedbackVerification $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JBPFeedbackVerification $model, array $attributes): array
    {
        return validator($attributes, [
            'status' => ['required', new Enum(JBPFeedbackVerificationStatus::class)],
            'is_investment_as_per_application' => ['required', 'integer', 'in:0,1'],
            'total_invested_amount' => ['required', 'integer', 'digits_between:2,50'],
            'location_of_business' => ['required', 'string', 'min:2', 'max:50'],
            'business_start_date' => ['required', 'date', 'max:10'],
            'is_verified_purchase' => ['required', 'integer', 'in:0,1'],
            'verified_date' => ['required', 'date'],
            'verified_id' => ['required', Rule::exists(JProjectFieldOfficer::getTableName(), 'officer_id')],
            'remarks' => ['nullable', 'min:2', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
