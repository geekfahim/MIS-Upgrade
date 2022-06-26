<?php

namespace App\Models\Jeebika\IGA;

use App\Enums\IGA\JSavingStatus;
use App\Models\Base\Acl\User;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JSaving extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'date' => 'immutable_datetime:Y-m-d',
        'confirmed_amount' => 'int',
        'approved_amount' => 'int',
        'status' => JSavingStatus::class,
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d'
    ];

    public static function listKey(): array
    {
        return ['id', 'date', 'confirmed_amount', 'approved_amount', 'collector_id', 'status', 'created_at'];
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collector_id', 'id');
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
