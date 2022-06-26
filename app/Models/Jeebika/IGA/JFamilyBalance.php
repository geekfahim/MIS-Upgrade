<?php

namespace App\Models\Jeebika\IGA;

use App\Models\Base\Family\Family;
use App\Traits\CommonTrait;
use App\Traits\ProjectManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JFamilyBalance extends Model
{
    use CommonTrait, ProjectManager, HasFactory;

    protected $casts = [
        'balance' => 'integer'
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
