<?php

namespace App\Models\Jeebika;

use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JIndicator;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JNeed extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'is_need' => 'integer',
        'is_implementation' => 'integer',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class);
    }

    public function j_project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function j_gro(): BelongsTo
    {
        return $this->belongsTo(JGro::class);
    }

    public function j_indicator(): BelongsTo
    {
        return $this->belongsTo(JIndicator::class);
    }
}
