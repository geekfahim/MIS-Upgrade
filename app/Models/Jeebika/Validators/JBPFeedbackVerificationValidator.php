<?php

namespace App\Models\Jeebika\Validators;

use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVerification;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Rules\Remarks;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JBPFeedbackVerificationValidator
{
    /**
     * @param JBPFeedbackVerification $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JBPFeedbackVerification $model, array $attributes): array
    {
        $data = validator($attributes, [
            'is_investment_as_per_application' => ['required', 'integer', 'in:0,1'],
            'total_invested_amount' => ['required', 'integer', 'digits_between:2,6'],
            'location_of_business' => ['required', 'string', 'min:2', 'max:50'],
            'business_start_date' => ['required', 'date', 'max:10'],
            'is_verified_purchase' => ['required', 'integer', 'in:0,1'],
            'verified_date' => ['required', 'date', 'max:10'],
            'verified_id' => ['required', Rule::exists(JProjectFieldOfficer::getTableName(), 'officer_id')],
            'remarks' => ['nullable', new Remarks(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, ['created_by']) : Arr::except($data, ['updated_by']);
    }
}
