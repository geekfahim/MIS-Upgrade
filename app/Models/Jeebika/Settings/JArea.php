<?php

namespace App\Models\Jeebika\Settings;

use App\Models\Base\Acl\User;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JArea extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public static function listKey(): array
    {
        return ['id', 'name', 'manager_id', 'j_zone_id', 'created_at'];
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function j_zone(): BelongsTo
    {
        return $this->belongsTo(JZone::class);
    }
}
