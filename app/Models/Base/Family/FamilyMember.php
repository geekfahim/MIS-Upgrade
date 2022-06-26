<?php

namespace App\Models\Base\Family;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Jeebika;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class FamilyMember extends Model
{
    use HasFactory, CommonTrait;

    protected $fillable = [
        'family_id',
        'mustahiq_id',
        'is_family_head',
        'relation_with_family_head',
        'created_by',
        'updated_by',
    ];

    public function mustahiq(): HasOne
    {
        return $this->hasOne(Mustahiq::class, "id", "mustahiq_id");
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function jeebika(): HasOneThrough
    {
        return $this->hasOneThrough(Jeebika::class, Family::class, 'id', 'family_id', 'family_id', 'id');
    }

}
