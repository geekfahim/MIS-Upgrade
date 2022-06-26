<?php

namespace App\Models\Jeebika\Project;

use App\Models\Base\Acl\User;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JProjectFieldOfficer extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $fillable = [
        'j_project_id',
        'officer_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
    ];

    public static function getOfficersByProjectId($project_id)
    {
        return User::getAll(['id', 'name'], ids: self::where('j_project_id', $project_id)->pluck('officer_id')->unique());
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
