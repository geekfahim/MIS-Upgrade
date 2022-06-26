<?php

namespace App\Models\Base\Family;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyExpense extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    public static function getAllByFamilyId($familyId, $selected = '*')
    {
        return static::select($selected)->where('family_id', $familyId)->get();
    }
}
