<?php

namespace App\Models\Jeebika\IGA\Business;

use App\Enums\IGA\JBusinessPlanInvestmentReturnType;
use App\Enums\IGA\JBusinessPlanMeetingStatus;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Models\Base\Family\Family;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\File;
use App\Models\Jeebika\IGA\JFamilyBalance;
use App\Models\Jeebika\IGA\JInvestmentReturn;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JInvestmentArea;
use App\Traits\CommonTrait;
use App\Traits\ProjectManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class JBusinessPlan extends Model
{
    use HasFactory, CommonTrait, SoftDeletes, ProjectManager;

    const RESOURCE_PATH = 'jBusinessPlan';

    protected $casts = [
        'is_joint' => 'bool',
        'status' => JBusinessPlanStatus::class,
        'meeting_status' => JBusinessPlanMeetingStatus::class,
        'business_duration' => 'integer',
        'business_seed_money' => 'integer',
        'possible_gross_income' => 'integer',
        'possible_gross_expense' => 'integer',
        'possible_net_profit' => 'integer',
        'investment_return_amount_each' => 'integer',
        'investment_return_type' => JBusinessPlanInvestmentReturnType::class,
        'is_business_experience' => 'bool',
        'business_experience_duration' => 'integer',
        'is_business_training' => 'bool',
        'business_training_duration' => 'integer',
        'is_valid_information' => 'bool',
        'is_previous_installment' => 'bool',
        'is_proposed_business_skill_and_experience' => 'bool',
        'is_general_savings' => 'bool',
        'is_recommended' => 'bool',
        'meeting_date' => 'immutable_date:Y-m-d',
        'approved_amount' => 'integer',
        'disbursement_date' => 'immutable_date:Y-m-d',
        'disbursement_amount' => 'integer',
        'approved_investment_return_type' => JBusinessPlanInvestmentReturnType::class,
        'updated_at' => 'immutable_datetime',
    ];

    public function resource(): MorphOne
    {
        return $this->morphOne(File::class, 'resource');
    }

    public function j_project(): BelongsTo
    {
        return $this->belongsTo(JProject::class);
    }

    public function j_gro(): BelongsTo
    {
        return $this->belongsTo(JGro::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function familyBalance(): HasOneThrough
    {
        return $this->hasOneThrough(JFamilyBalance::class, Family::class, 'id', 'family_id', 'family_id', 'id')->withDefault(['balance' => 0]);
    }

    public function sources(): HasMany
    {
        return $this->hasMany(JBusinessPlanSource::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(JBusinessPlanField::class);
    }

    public function risks(): HasMany
    {
        return $this->hasMany(JBusinessPlanRisk::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(JBusinessPlanFamily::class);
    }

    public function j_investment_area(): BelongsTo
    {
        return $this->belongsTo(JInvestmentArea::class, 'j_investment_area_id');
    }

    public function j_investment_approved_area(): BelongsTo
    {
        return $this->belongsTo(JInvestmentArea::class, 'approved_investment_area_id');
    }

    public function resolution_processed_by(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class, 'resolution_processed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Mustahiq::class, 'approved_by', 'id');
    }

    public function total_returns(): HasMany
    {
        return $this->hasMany(JInvestmentReturn::class, 'j_business_plan_id');
    }
}
