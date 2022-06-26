<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilyNeighbourHelpType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyNeighbourHelp;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyNeighbourHelpValidator
{
    /**
     * @param FamilyNeighbourHelp $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyNeighbourHelp $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'neighbour_help_type' => ['required', new Enum(FamilyNeighbourHelpType::class)],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
