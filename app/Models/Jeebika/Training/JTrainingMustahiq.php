<?php

namespace App\Models\Jeebika\Training;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class JTrainingMustahiq extends Model
{
    use HasFactory, CommonTrait;

    protected $table = 'j_training_mustahiq';

    protected $casts = [
        'is_present' => 'boolean'
    ];

    /*public function j_trainings(): BelongsToMany
    {
        return $this->belongsToMany(JTraining::class, 'j_training_mustahiq', 'mustahiq_id', 'j_training_id')
            ->withPivot(['is_present'])
            ->withTimestamps();
    }
*/
    public function mustahiq(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class);
    }

}
