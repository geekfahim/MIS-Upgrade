<?php

namespace App\Models\Jeebika\Validators;

use App\Models\Jeebika\Settings\JInvestmentArea;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JInvestmentAreaValidator
{
    /**
     * @param JInvestmentArea $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JInvestmentArea $model, array $attributes): array
    {
//        dd($model);
        $data = validator($attributes, [
            'name'       => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(JInvestmentArea::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(JInvestmentArea::getTableName(), 'name')),
            ],
            'created_by' => ['required'],
            'updated_by' => ['required'],
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
