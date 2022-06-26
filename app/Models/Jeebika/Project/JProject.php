<?php

namespace App\Models\Jeebika\Project;

use App\Enums\JGroStatus;
use App\Models\Base\Acl\User;
use App\Models\Base\Settings\District;
use App\Models\File;
use App\Models\Jeebika\Jeebika;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Settings\JArea;
use App\Models\Jeebika\Settings\JZone;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JProject extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    const RESOURCE_PATH = 'jProject';

    protected $fillable = [
        'name',
        'district_id',
        'manager_id',
        'j_zone_id',
        'j_area_id',
        'start_date',
        'end_date',
        'number_of_household_cover',
        'remarks',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'status' => JGroStatus::class,
        'manager_id' => 'integer',
        'district_id' => 'integer',
        'j_zone_id' => 'integer',
        'j_area_id' => 'integer',
        'start_date' => 'immutable_date:Y-m-d',
        'end_date' => 'immutable_date:Y-m-d',
        'number_of_household_cover' => 'integer',
        'created_by' => 'integer',
        'created_at' => 'immutable_datetime',
        'updated_by' => 'integer',
        'updated_at' => 'immutable_datetime',
    ];

    public static function getAll($selected = "*", JGroStatus $status = JGroStatus::Active, $manager = null)
    {
        return static::select($selected)
            ->when($status, function ($sql) use ($status) {
                $sql->where("status", $status);
            })->when($manager, function ($sql) use ($manager) {
                $sql->where("manager_id", $manager);
            })->orderBy("name")->get();
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sponsors(): HasMany
    {
        return $this->hasMany(JProjectSponsor::class);
    }

    public function field_officers(): HasMany
    {
        return $this->hasMany(JProjectFieldOfficer::class);
    }

    public function j_zone(): BelongsTo
    {
        return $this->belongsTo(JZone::class);
    }

    public function j_area(): BelongsTo
    {
        return $this->belongsTo(JArea::class);
    }

    public function gros(): HasMany
    {
        return $this->hasMany(JGro::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Jeebika::class);
    }

    public function resource(): MorphMany
    {
        return $this->morphMany(File::class, 'resource');
    }

    public function j_implementations(): HasMany
    {
        return $this->hasMany(JImplementationPlan::class);
    }
}
