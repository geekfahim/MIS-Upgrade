<?php

namespace App\Models\Jeebika\Training;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class JTrainingImplementation extends Model
{
    use HasFactory, CommonTrait;

    CONST ATTENDANCE =[1=>'Present',2=>'Absent'];

    protected $casts = [
        'is_implemented' => 'boolean'
    ];
    public function training(): BelongsTo
    {
        return $this->belongsTo(JTraining::class);
    }
}
