<?php

namespace App\Models\Base\Family;

use App\Models\Base\Settings\Disaster;
use App\Models\Base\Settings\Recover;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyDisaster extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $with = ['disaster:id,name', 'recover:id,name'];

    public static function getAllByFamilyId($familyId, $selected = '*')
    {
        return static::select($selected)->where('family_id', $familyId)->get();
    }

    public function disaster(): BelongsTo
    {
        return $this->belongsTo(Disaster::class);
    }

    public function recover(): BelongsTo
    {
        return $this->belongsTo(Recover::class);
    }
}
