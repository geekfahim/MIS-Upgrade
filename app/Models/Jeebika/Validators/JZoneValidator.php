<?php

namespace App\Models\Jeebika\Validators;

use App\Models\Base\Acl\User;
use App\Models\Jeebika\Settings\JZone;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JZoneValidator
{
    /**
     * @param JZone $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JZone $model, array $attributes): array
    {
        $data = validator($attributes, [
            'name' => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(JZone::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(JZone::getTableName(), 'name')),
            ],
            'manager_id' => ['nullable', 'numeric', Rule::exists(User::getTableName(), 'id')],
            'created_by' => ['required'],
            'updated_by' => ['required'],
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
