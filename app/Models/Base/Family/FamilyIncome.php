<?php

namespace App\Models\Base\Family;

use App\Models\Base\Settings\Income;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyIncome extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $with = ['income:id,name'];

    public static function getAllByFamilyId($familyId, $selected = '*')
    {
        return static::select($selected)->where('family_id', $familyId)->get();
    }

    public function income(): BelongsTo
    {
        return $this->belongsTo(Income::class);
    }
}
