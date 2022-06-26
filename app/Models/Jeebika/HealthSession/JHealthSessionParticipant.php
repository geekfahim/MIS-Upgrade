<?php

namespace App\Models\Jeebika\HealthSession;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JHealthSessionParticipant extends Model
{
    use HasFactory, CommonTrait;

    protected $table = 'mustahiq_pivot_j_health_session';

    protected $casts = [
        'is_present' => 'boolean'
    ];

    public function mustahiq(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class);
    }

}
