<?php

namespace App\Models\Validators;

use App\Enums\JGroStatus;
use App\Models\Base\Acl\User;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Sponsor;
use App\Models\File;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JArea;
use App\Models\Jeebika\Settings\JZone;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JProjectValidator
{
    /**
     * @param JProject $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JProject $model, array $attributes): array
    {
        $data = validator($attributes, [
            'name' => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(JProject::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(JProject::getTableName(), 'name')),
            ],
            'manager_id' => ['required', 'integer', Rule::exists(User::getTableName(), 'id'),
                Rule::when($model->exists, Rule::unique(JProject::getTableName(), 'manager_id')->where('status', JGroStatus::Active->value)->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(JProject::getTableName(), 'manager_id')->where('status', JGroStatus::Active->value))
            ],
            'status' => ['required', new Enum(JGroStatus::class)],
            'number_of_household_cover' => ['required', 'numeric', 'digits_between:1,5'], // , 'size:1'
            'start_date' => ['required', 'date', 'max:10'],
            'end_date' => ['required', 'date', 'max:10', 'after:start_date'],
            'district_id' => ['required', 'integer', Rule::exists(District::getTableName(), 'id')],
            'j_zone_id' => ['nullable', Rule::exists(JZone::getTableName(), 'id')],
            'j_area_id' => ['nullable', Rule::exists(JArea::getTableName(), 'id')],
            'remarks' => ['nullable', 'max:999'],
            'sponsor_ids' => ['required', 'array'],
            'sponsor_ids.*' => ['required', 'integer', Rule::exists(Sponsor::getTableName(), 'id')],
            'field_officer_ids' => ['required', 'array'],
            'field_officer_ids.*' => ['required', 'integer', Rule::exists(User::getTableName(), 'id')],
            'files' => ['array'],
            'files.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:100'], // 100kb
            'file_remarks' => ['array'],
            'file_remarks.*' => ['nullable', new Name(), 'max:999'],
            'delete_file_ids' => ['array'],
            'delete_file_ids.*' => ['nullable', 'integer', Rule::exists(File::getTableName(), 'id')],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ], [
            'manager_id.unique' => 'The :attribute has already active project.',
            'sponsor_ids.*.*' => 'The selected sponsor is invalid.',
            'field_officer_ids' => 'The selected field officer is invalid.',
            'files.*.mimes' => 'The selected file type is invalid, allowed type are jpeg,jpg,png,pdf',
            'files.*.max' => 'The selected file may not be greater than 100kb.',
            'file_remarks.*.*' => 'The selected file remarks is invalid.',
            'delete_file_ids.*.*' => 'The deleted files is invalid.',
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
