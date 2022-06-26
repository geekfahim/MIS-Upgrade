<?php

namespace App\Models\Jeebika\Settings;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JInvestmentArea extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d',
    ];

    public static function listKey(): array
    {
        return ['id', 'name', 'created_at'];
    }

    public static function getAll($selected = "*")
    {
        return static::select($selected)->get();
    }
}
