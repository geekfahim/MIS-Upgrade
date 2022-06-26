<?php

namespace App\Models\Base\Mustahiq;

use App\Enums\Evaluation;
use App\Enums\MustahiqEducationLevel;
use App\Enums\MustahiqLivingStatus;
use App\Enums\MustahiqMaritalStatus;
use App\Enums\MustahiqOrphanType;
use App\Enums\MustahiqPregnancyStatus;
use App\Enums\MustahiqRelationalLivingStatus;
use App\Models\Base\Settings\District;
use App\Models\Base\Settings\Occupation;
use App\Models\Base\Settings\Union;
use App\Models\Base\Settings\Upazila;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MustahiqDetail extends Model
{
    use CommonTrait, HasFactory, SoftDeletes;

    protected $casts = [
        'evaluation' => Evaluation::class,
        'is_orphan' => 'int',
        'orphan_type' => MustahiqOrphanType::class,
        'pregnancy_status' => MustahiqPregnancyStatus::class,
        'father_mobile' => 'int',
        'father_living_status' => MustahiqRelationalLivingStatus::class,
        'mother_mobile' => 'int',
        'mother_living_status' => MustahiqRelationalLivingStatus::class,
        'marital_status' => MustahiqMaritalStatus::class,
        'spouse_mobile' => 'int',
        'spouse_living_status' => MustahiqRelationalLivingStatus::class,
        'highest_education_level' => MustahiqEducationLevel::class,
        'is_earn_ability' => 'int',
        'monthly_income' => 'int',
        'living_status' => MustahiqLivingStatus::class,
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
    ];

    public function mustahiq(): belongsTo
    {
        return $this->belongsTo(Mustahiq::class);
    }

    public function occupation(): belongsTo
    {
        return $this->belongsTo(Occupation::class);
    }

    public function present_district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'present_district_id', 'id');
    }

    public function present_upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class, 'present_upazila_id', 'id');
    }

    public function present_union(): BelongsTo
    {
        return $this->belongsTo(Union::class, 'present_union_id', 'id');
    }
}
