<?php

namespace App\Models\Jeebika\Project;

use App\Models\Base\Settings\Sponsor;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JProjectSponsor extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $fillable = [
        'j_project_id',
        'sponsor_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }
}
