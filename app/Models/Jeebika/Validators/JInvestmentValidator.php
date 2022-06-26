<?php

namespace App\Models\Jeebika\Validators;

use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\JInvestment;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JInvestmentValidator
{
    /**
     * @param JInvestment $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JInvestment $model, array $attributes): array
    {

        $data = validator($attributes, [
            'date' => ['required', 'date', 'min:2', 'max:50'],
            'reference_number' => ['nullable', 'string', 'max:50'],
            'confirmed_amount' => ['required', 'numeric', 'digits_between:0,50'],
            'j_business_plan_id' => ['required', 'numeric', Rule::exists(JBusinessPlan::getTableName(), 'id')],
            'remarks' => ['nullable', 'string', 'min:2', 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required'],
        ])->validate();

        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
