<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\IGA\JSavingStatus;
use App\Models\Jeebika\IGA\JSaving;
use App\Models\Jeebika\Project\JProjectFieldOfficer;
use App\Rules\Remarks;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JSavingsApproveValidator
{
    /**
     * @param JSaving $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JSaving $model, array $attributes): array
    {
        return validator($attributes, [
            'collector_id' => ['required', Rule::exists(JProjectFieldOfficer::getTableName(), 'officer_id')],
            'status' => ['required', new Enum(JSavingStatus::class)],
            'date' => ['required', 'date', 'max:10'],
            'approved_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks' => ['nullable', new Remarks(), 'max:999'],
            'updated_by' => ['required'],
        ])->validate();
    }
}
