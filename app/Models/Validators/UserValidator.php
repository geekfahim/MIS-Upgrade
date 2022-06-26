<?php

namespace App\Models\Validators;

use App\Enums\UserStatus;
use App\Models\Base\Acl\User;
use App\Rules\Mobile;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class UserValidator
{
    /**
     * @param User $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(User $model, array $attributes): array
    {
        $data = validator($attributes, [
            'name' => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(User::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(User::getTableName(), 'name'))
            ],
            'office_id' => ['required', 'numeric', 'digits_between:3,10',
                Rule::when($model->exists, Rule::unique(User::getTableName(), 'office_id')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(User::getTableName(), 'office_id'))
            ],
            'email' => ['required', 'email',
                Rule::when($model->exists, Rule::unique(User::getTableName(), 'email')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(User::getTableName(), 'email'))
            ],
            'password' => ['string', 'min:6', 'max:16', 'confirmed',
                Rule::when($model->exists, ['sometimes', 'required']),
                Rule::when(!$model->exists, ['required'])
            ],
            'mobile' => ['nullable', 'numeric', new Mobile()],
            'status' => ['required', new Enum(UserStatus::class)],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
