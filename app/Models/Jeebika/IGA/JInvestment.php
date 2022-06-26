<?php

namespace App\Models\Jeebika\IGA;

use App\Enums\IGA\JInvestmentStatus;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use App\Traits\ProjectManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JInvestment extends Model
{
    use HasFactory, CommonTrait, ProjectManager, SoftDeletes;

    protected $casts = [
        'date' => 'immutable_datetime:Y-m-d',
        'confirmed_amount' => 'int',
        'approved_amount' => 'int',
        'status' => JInvestmentStatus::class,
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d'
    ];

    public static function listKey(): array
    {
        return ['id', 'date', 'status', 'confirmed_amount', 'approved_amount', 'reference_number', 'j_business_plan_id', 'created_at'];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(JBusinessPlan::class, 'j_business_plan_id', 'id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(JProject::class, 'j_project_id', 'id');
    }

    public function gro(): BelongsTo
    {
        return $this->belongsTo(JGro::class, 'j_gro_id', 'id');
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
