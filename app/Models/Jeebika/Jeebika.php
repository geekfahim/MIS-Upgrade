<?php

namespace App\Models\Jeebika;

use App\Models\Base\Family\Family;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jeebika extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $guarded = [];

    public function j_project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function j_gro(): BelongsTo
    {
        return $this->belongsTo(JGro::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

}
