<?php

namespace App\Models\Jeebika\Settings;

use App\Enums\IndicatorStatus;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JIndicator extends Model
{
    use CommonTrait, HasFactory, SoftDeletes;

    protected $casts = [
        'status' => IndicatorStatus::class,
        'sequence' => 'integer',
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d',
    ];

    public static function listKey(): array
    {
        return ['id', 'name', 'type', 'sequence', 'program_type', 'status', 'created_at'];
    }

    public static function getAll($selected = "*", $orderBy = "name", $status = IndicatorStatus::Active)
    {
        return static::select($selected)
            ->when($status, function ($sql) use ($status) {
                $sql->where("status", $status->value);
            })
            ->when($orderBy, function ($sql) use ($orderBy) {
                $sql->orderBy($orderBy);
            })->get();
    }
}
