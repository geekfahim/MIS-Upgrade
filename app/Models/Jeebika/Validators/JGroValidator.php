<?php

namespace App\Models\Jeebika\Validators;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Bank;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class JGroValidator
{
    public function validate(JGro $JGro, array $attributes): array
    {
        $data = validator($attributes,
            [
                'name' => [Rule::when($JGro->exists, 'sometimes'), 'required', new Name(), 'min:2', 'max:50'],
                'j_project_id' => [Rule::when($JGro->exists, 'sometimes'), 'required', 'numeric', 'max:999', Rule::exists(JProject::getTableName(), 'id')],
                'leader_id' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', 'numeric', 'max:999', Rule::exists(Mustahiq::getTableName(), 'id')],
                'cashier_id' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', 'numeric', 'max:999', Rule::exists(Mustahiq::getTableName(), 'id')],
                'number_of_family' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', 'numeric', 'digits_between:0,10'],
                'reference_id' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', new Name(), 'max:20'],
                'bank_id' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', 'numeric', Rule::exists(Bank::getTableName(), 'id')],
                'bank_branch_name' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', new Name(), 'max:20'],
                'bank_account_name' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', new Name(), 'max:20'],
                'bank_account_number' => [Rule::when($JGro->exists, 'sometimes'), 'nullable', new Name(), 'max:20'],
            ]
        )->validate();
        return $JGro->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
