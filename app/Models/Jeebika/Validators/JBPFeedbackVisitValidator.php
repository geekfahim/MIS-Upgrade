<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JBPFeedbackVisitBusinessStatus;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVisit;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Rules\Remarks;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JBPFeedbackVisitValidator
{
    /**
     * @param JBPFeedbackVisit $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JBPFeedbackVisit $model, array $attributes): array
    {
        $data = validator($attributes, [
            'visit_date' => ['required', 'date', 'max:10'],
            'visit_id' => ['required', Rule::exists(JProjectFieldOfficer::getTableName(), 'officer_id')],
            'business_status' => ['required', new Enum(JBPFeedbackVisitBusinessStatus::class)],
            'remarks' => ['nullable', 'min:2', new Remarks(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
