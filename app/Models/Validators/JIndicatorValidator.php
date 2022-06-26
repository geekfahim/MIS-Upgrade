<?php

namespace App\Models\Validators;

use App\Enums\IndicatorStatus;
use App\Enums\IndicatorType;
use App\Models\Jeebika\Settings\JIndicator;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class JIndicatorValidator
{
    /**
     * @param JIndicator $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JIndicator $model, array $attributes): array
    {
        $data = validator($attributes, [
            'name' => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(JIndicator::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(JIndicator::getTableName(), 'name'))
            ],
            'type' => ['required', new Enum(IndicatorType::class)],
            'program_type' => ['required', Rule::in(getIndicatorProgramTypesOnlyNames())],
            'status' => ['required', new Enum(IndicatorStatus::class)],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        $data['sequence'] = getIndicatorProgramTypes()[array_search($data['program_type'], getIndicatorProgramTypesOnlyNames())]['sequence'];
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
