<?php

namespace App\Models\Jeebika\HealthSession;

use App\Enums\JHealthSessionStatus;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JHealthSession extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'status'     => JHealthSessionStatus::class,
        'start_date' => 'immutable_date:Y-m-d',
        'end_date'   => 'immutable_date:Y-m-d',
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
    ];

    public static function ListKey(): array
    {
        return ['id', 'session_heading', 'session_method', 'j_project_id', 'start_date', 'end_date', 'session_location', 'resource_person_name', 'resource_person_phone', 'resource_person_designation', 'status', 'remarks'];
    }

    public function j_project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function mustahiqs(): BelongsToMany
    {
        return $this->belongsToMany(Mustahiq::class, JHealthSessionParticipant::class)->withPivot(['is_present'])->withTimestamps();
    }

    public function health_session_present_mustahiqs(): BelongsToMany
    {
        return $this->belongsToMany(Mustahiq::class, JHealthSessionParticipant::class)->withPivot(['is_present'])->wherePivot('is_present', 1)->withTimestamps();
    }

}

