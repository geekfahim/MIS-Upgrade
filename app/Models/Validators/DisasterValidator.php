<?php

namespace App\Models\Validators;

use App\Models\Base\Settings\Disaster;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DisasterValidator
{
    /**
     * @param Disaster $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(Disaster $model, array $attributes): array
    {
        $data = validator($attributes, [
            'name' => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(Disaster::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(Disaster::getTableName(), 'name'))
            ],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
