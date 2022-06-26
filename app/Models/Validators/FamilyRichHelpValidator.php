<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilyRichHelpType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyRichHelp;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyRichHelpValidator
{
    /**
     * @param FamilyRichHelp $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyRichHelp $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'rich_help_type' => ['required', new Enum(FamilyRichHelpType::class)],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
