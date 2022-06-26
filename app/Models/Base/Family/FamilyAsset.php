<?php

namespace App\Models\Base\Family;

use App\Models\Base\Settings\Asset;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyAsset extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $with = ['asset:id,name'];

    public static function getAllByFamilyId($familyId, $selected = '*')
    {
        return static::select($selected)->where('family_id', $familyId)->get();
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
