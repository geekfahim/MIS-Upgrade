<?php

namespace App\Models\Validators;

use App\Enums\SponsorStatus;
use App\Enums\SponsorType;
use App\Models\Base\Settings\Sponsor;
use App\Rules\Mobile;
use App\Rules\Name;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class SponsorValidator
{
    /**
     * @param Sponsor $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(Sponsor $model, array $attributes): array
    {
        $data = validator($attributes, [
            'name' => ['required', new Name(), 'min:2', 'max:50',
                Rule::when($model->exists, Rule::unique(Sponsor::getTableName(), 'name')->ignore($model)),
                Rule::when(!$model->exists, Rule::unique(Sponsor::getTableName(), 'name'))
            ],
            'mobile' => ['required', new Mobile()],
            'type' => ['required', new Enum(SponsorType::class)],
            'phone' => ['nullable', 'numeric', 'digits_between:2,51'],
            'contact_person' => ['nullable', new Name(), 'max:50'],
            'contact_person_mobile' => ['nullable', new Mobile()],
            'address' => ['nullable', new Name(), 'max:999'],
            'status' => ['required', new Enum(SponsorStatus::class)],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
