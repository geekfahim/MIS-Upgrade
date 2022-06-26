<?php

namespace App\Models\Jeebika\HealthSession;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JHealthSessionFeedback extends Model
{
    use HasFactory, CommonTrait;

    public function health_session(): BelongsTo
    {
        return $this->belongsTo(JHealthSession::class, 'j_health_session_id', 'id');
    }

    public function mustahiq(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class, 'mustahiq_id', 'id');
    }
}
