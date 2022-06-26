<?php

namespace App\Models\Jeebika\Validators;

use App\Enums\JTrainingStatus;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Training\JTraining;
use App\Rules\Name;
use App\Rules\Phone;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JTrainingValidator
{
    /**
     * @param JTraining $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JTraining $model, array $attributes): array
    {
        $data = validator($attributes, [
            'j_project_id'                => ['nullable', 'numeric', Rule::exists(JProject::getTableName(), 'id')],
            'training_heading'            => ['required', new Name(), 'min:2', 'max:50'],
            'training_type'               => ['required', 'in:Vocational,Skill'],
            'trade_id'                    => ['required'],
            'training_method'             => ['required', 'in:Online,Offline'],
            'training_location'           => ['nullable', 'string', 'max:50'],
            'start_date'                  => ['required', 'date'],
            'end_date'                    => ['required', 'date', 'after_or_equal:start_date'],
            'resource_person_name'        => ['required', new Name(), 'min:2', 'max:50'],
            'resource_person_phone'       => ['nullable', new Phone()],
            'resource_person_designation' => ['nullable', new Name(), 'min:2', 'max:50'],
            'remarks'                     => ['nullable', 'min:2', 'max:999'],
            'status'                      => ['nullable'],
            'created_by'                  => ['required'],
            'updated_by'                  => ['required'],
        ])->validate();

        $data['status'] = $model->exists ? $data['status'] : JTrainingStatus::Upcoming;

        if ($data['training_type'] === "Vocational") {
            $data['vocational_id'] = $data['trade_id'];
            $data['skill_id'] = null;
        }
        if ($data['training_type'] === "Skill") {
            $data['skill_id'] = $data['trade_id'];
            $data['vocational_id'] = null;
        }

        return $model->exists ? Arr::except($data, 'trade_id', 'created_by') : Arr::except($data, 'trade_id', 'updated_by');
    }
}
