<?php

namespace App\Models\Jeebika\Validators;

use App\Models\Base\Acl\User;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\JInvestmentReturn;
use App\Rules\Remarks;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JInvestmentReturnValidator
{
    /**
     * @param JInvestmentReturn $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(JInvestmentReturn $model, array $attributes): array
    {
        $data = validator($attributes, [
            'j_business_plan_id' => ['required', 'numeric', Rule::exists(JBusinessPlan::getTableName(), 'id')],
            'collector_id' => ['required', 'numeric', Rule::exists(User::getTableName(), 'id')],
            'date' => ['required', 'date', 'max:10'],
            'confirmed_amount' => ['required', 'numeric', 'digits_between:2,6'],
            'remarks' => ['nullable', new Remarks(), 'max:999'],
            'created_by' => ['required'],
            'updated_by' => ['required'],
        ])->validate();

        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');

    }
}
