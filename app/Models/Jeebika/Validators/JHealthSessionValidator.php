<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\JHealthSessionStatus;
use App\Models\Jeebika\HealthSession\JHealthSession;
use App\Models\Jeebika\Project\JProject;
use App\Rules\Name;
use App\Rules\Phone;
use App\Rules\Remarks;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JHealthSessionValidator
{
    /**
     * @param JHealthSession $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JHealthSession $model, array $attributes): array
    {
        $data = validator($attributes, [
            'j_project_id' => ['nullable', 'numeric', Rule::exists(JProject::getTableName(), 'id')],
            'session_heading' => ['required', new Name(), 'min:2', 'max:50'],
            'session_method' => ['required', 'in:Online,Offline'],
            'session_location' => ['nullable', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'resource_person_name' => ['required', new Name(), 'min:2', 'max:50'],
            'resource_person_phone' => ['nullable', new Phone()],
            'resource_person_designation' => ['nullable', new Name(), 'min:2', 'max:50'],
            'remarks' => ['nullable', 'min:2', new Remarks(), 'max:999'],
            'status' => ['nullable', new Enum(JHealthSessionStatus::class)],
            'created_by' => ['required'],
            'updated_by' => ['required'],
        ])->validate();

        $data['status'] = $model->exists ? $data['status'] : JHealthSessionStatus::Upcoming;
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
