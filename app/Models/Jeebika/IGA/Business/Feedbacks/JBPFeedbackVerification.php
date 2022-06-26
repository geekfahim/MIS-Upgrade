<?php

namespace App\Models\Jeebika\IGA\Business\Feedbacks;

use App\Enums\IGA\JBPFeedbackVerificationStatus;
use App\Models\Base\Acl\User;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JBPFeedbackVerification extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'status' => JBPFeedbackVerificationStatus::class,
        'is_investment_as_per_application' => 'integer',
        'is_verified_purchase' => 'integer',
        'verified_date' => 'immutable_date:Y-m-d',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public static function listKey(): array
    {
        return ['id', 'verified_date', 'verified_id', 'total_invested_amount', 'status', 'is_investment_as_per_application', 'is_verified_purchase', 'created_at'];
    }

    public function j_business_plan(): BelongsTo
    {
        return $this->belongsTo(JBusinessPlan::class);
    }

    public function verified_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_id', 'id');
    }
}
