<?php

namespace App\Models\Validators;

use App\Models\Base\Settings\Occupation;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OccupationValidator
{
    /**
     * @param Occupation $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(Occupation $model, array $attributes): array
    {
        $data = validator($attributes, [
            'name' => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(Occupation::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(Occupation::getTableName(), 'name'))
            ],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
