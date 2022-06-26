<?php

namespace App\Models\Jeebika\Project;

use App\Enums\JImplementationPlanStatus;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Settings\JIndicator;
use App\Traits\CommonTrait;
use App\Traits\ProjectManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JImplementationPlan extends Model
{
    use HasFactory, CommonTrait, SoftDeletes, ProjectManager;

    protected $casts = [
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
        'implement_status' => JImplementationPlanStatus::class
    ];

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

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
