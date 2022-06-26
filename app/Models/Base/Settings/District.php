<?php

namespace App\Models\Base\Settings;

use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use CommonTrait, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d',
    ];

    public static function getAll($selected = "*")
    {
        return static::select($selected)->orderBy("name")->get();
    }

    public function upazilas(): HasMany
    {
        return $this->hasMany(Upazila::class);
    }
}
