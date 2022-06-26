<?php

namespace App\Models\Jeebika\Validators;

use App\Models\Jeebika\IGA\JMiscellaneous;
use App\Rules\Remarks;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class JMiscellaneousValidator
{
    /**
     * @param JMiscellaneous $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JMiscellaneous $model, array $attributes): array
    {

        $data = validator($attributes, [
            'date'             => ['required', 'date', 'max:10'],
            'confirmed_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks'          => ['nullable', new Remarks(), 'max:999'],
            'created_by'       => ['required'],
            'updated_by'       => ['required'],
        ])->validate();

        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}

