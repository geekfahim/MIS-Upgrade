<?php

namespace App\Models\Validators;

use App\Enums\Evaluation;
use App\Enums\FamilyConflictResolveType;
use App\Models\Base\Family\Family;
use App\Models\Base\Family\FamilyConflictResolve;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class FamilyConflictResolveValidator
{
    /**
     * @param FamilyConflictResolve $model
     * @param array $attributes
     * @return array
     * @throws ValidationException
     */
    public function validate(FamilyConflictResolve $model, array $attributes): array
    {
        $data = validator($attributes, [
            'family_id' => ['sometimes', 'required', Rule::exists(Family::getTableName(), 'id')],
            'evaluation' => ['sometimes', 'required', new Enum(Evaluation::class)],
            'conflict_resolve_type' => ['required', new Enum(FamilyConflictResolveType::class)],
            'created_by' => ['required'],
            'updated_by' => ['required']
        ])->validate();
        return $model->exists ? Arr::except($data, 'created_by') : Arr::except($data, 'updated_by');
    }
}
