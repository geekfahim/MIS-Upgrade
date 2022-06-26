<?php

namespace App\Models\Base\Mustahiq;

use App\Models\Base\Settings\Skill;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MustahiqSkill extends Model
{
    use CommonTrait, HasFactory, SoftDeletes;

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}
