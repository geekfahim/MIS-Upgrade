<?php

namespace App\Models\Base\Settings;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disaster extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public static function getAll($selected = [])
    {
        return static::select(array_merge(['id', 'name'], $selected))->orderBy("name")->get();
    }
}
