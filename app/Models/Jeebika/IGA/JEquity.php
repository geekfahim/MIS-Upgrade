<?php

namespace App\Models\Jeebika\IGA;

use App\Enums\IGA\JEquityStatus;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JEquity extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'status' => JEquityStatus::class,
        'confirmed_amount' => 'int',
        'approved_amount' => 'int',
        'date' => 'immutable_datetime:Y-m-d',
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d'
    ];

    public static function listKey(): array
    {
        return ['id', 'date', 'status', 'confirmed_amount', 'approved_amount', 'created_at'];
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
