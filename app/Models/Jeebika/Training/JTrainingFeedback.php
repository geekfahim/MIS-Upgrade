<?php

namespace App\Models\Jeebika\Training;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JTrainingFeedback extends Model
{
    use HasFactory, CommonTrait;

    protected $table = 'j_training_feedbacks';

    protected $casts = [
        'training_real_life' => 'boolean'
    ];

    public function training(): BelongsTo
    {
        return $this->belongsTo(JTraining::class, 'j_training_id', 'id');
    }

    public function mustahiq(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class, 'mustahiq_id', 'id');
    }


}
