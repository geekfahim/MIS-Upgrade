<?php

namespace App\Models\Jeebika\IGA\Business;

use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JBusinessPlanFamily extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    public function jProject(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function jGro(): BelongsTo
    {
        return $this->belongsTo(JGro::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
