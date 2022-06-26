<?php

namespace App\Models\Jeebika\Training;

use App\Enums\JTrainingMethod;
use App\Enums\JTrainingStatus;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Skill;
use App\Models\Base\Settings\Vocational;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use App\Traits\ProjectManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JTraining extends Model
{
    use HasFactory, CommonTrait, SoftDeletes, ProjectManager;

    protected $casts = [
        'status' => JTrainingStatus::class,
        'training_method ' => JTrainingMethod::class,
        'start_date' => 'immutable_date:Y-m-d',
        'end_date' => 'immutable_date:Y-m-d',
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
    ];

    public static function ListKey(): array
    {
        return ['id', 'training_heading', 'training_type', 'training_method', 'j_project_id', 'vocational_id', 'skill_id', 'start_date', 'end_date', 'training_location', 'resource_person_name', 'resource_person_phone', 'resource_person_designation', 'status', 'remarks'];
    }

    public function j_project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function vocational(): BelongsTo
    {
        return $this->belongsTo(Vocational::class);
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function mustahiqs(): BelongsToMany
    {
        return $this->belongsToMany(Mustahiq::class, JTrainingMustahiq::class)->withPivot(['is_present'])
            ->withTimestamps();
//        return $this->belongsToMany(Mustahiq::class, JTrainingMustahiq::class, 'j_training_id', 'mustahiq_id');
        /*        return $this->belongsToMany(JTraining::class, 'j_training_mustahiq', 'mustahiq_id', 'j_training_id')
                    ->withPivot(['is_present'])
                    ->withTimestamps();*/
    }

    public function training_present_mustahiqs(): BelongsToMany
    {
        return $this->belongsToMany(Mustahiq::class, JTrainingMustahiq::class)
            ->withPivot(['is_present'])
            ->wherePivot('is_present', 1)
            ->withTimestamps();
    }

}

