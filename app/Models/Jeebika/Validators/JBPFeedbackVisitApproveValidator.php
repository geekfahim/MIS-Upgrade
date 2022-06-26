<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JBPFeedbackVisitBusinessStatus;
use App\Enums\IGA\JBPFeedbackVisitStatus;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVisit;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Rules\Remarks;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JBPFeedbackVisitApproveValidator
{
    /**
     * @param JBPFeedbackVisit $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JBPFeedbackVisit $model, array $attributes): array
    {
        return validator($attributes, [
            'status' => ['required', new Enum(JBPFeedbackVisitStatus::class)],
            'visit_date' => ['required', 'date', 'max:10'],
            'visit_id' => ['required', Rule::exists(JProjectFieldOfficer::getTableName(), 'officer_id')],
            'business_status' => ['required', new Enum(JBPFeedbackVisitBusinessStatus::class)],
            'remarks' => ['nullable', 'min:2', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
