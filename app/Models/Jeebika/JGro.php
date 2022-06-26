<?php

namespace App\Models\Jeebika;

use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Bank;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\JInvestment;
use App\Models\Jeebika\IGA\JSaving;
use App\Models\Jeebika\IGA\JEquity;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class JGro extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'j_project_id',
        'reference_id',
        'number_of_family',
        'leader_id',
        'cashier_id',
        'bank_id',
        'bank_branch_name',
        'bank_account_name',
        'bank_account_number',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
    ];

    public static function getAll($selected = "*")
    {
        return static::select($selected)->orderBy("name")->get();
    }

    public static function getAllByProjectId($project_id, $selected = "*")
    {
        return static::select($selected)->where('j_project_id', $project_id)->orderBy("name")->get();
    }

    public static function getRowById($id, $selected = "*")
    {
        return static::select($selected)->findOrFail($id);
    }

    public function j_project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class);
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Jeebika::class);
    }

    public function businessPlans(): HasMany
    {
        return $this->hasMany(JBusinessPlan::class, 'j_gro_id');
    }

    public function j_equities(): HasMany
    {
        return $this->hasMany(JEquity::class, 'j_gro_id');
    }

    public function investments(): HasMany
    {
        return $this->hasMany(JInvestment::class, 'j_gro_id');
    }

    public function savings(): HasMany
    {
        return $this->hasMany(JSaving::class, 'j_gro_id');
    }
}
