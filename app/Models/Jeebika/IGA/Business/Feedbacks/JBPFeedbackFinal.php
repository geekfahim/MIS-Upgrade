<?php

namespace App\Models\Jeebika\IGA\Business\Feedbacks;

use App\Enums\IGA\JBPFeedbackFinalProfitStatus;
use App\Enums\IGA\JBPFeedbackFinalStatus;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JBPFeedbackFinal extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'profit_status' => JBPFeedbackFinalProfitStatus::class,
        'status' => JBPFeedbackFinalStatus::class,
        'is_recommended' => 'integer',
        'is_investment_as_per_application' => 'integer',
        'business_length' => 'integer',
        'total_investment' => 'integer',
        'total_return' => 'integer',
        'date' => 'immutable_date:Y-m-d',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public static function listkey(): array
    {
        return ['id', 'final_date', 'is_recommended', 'is_investment_as_per_application', 'business_tenure', 'total_investment', 'total_return', 'status', 'investment_findings', 'profit_status', 'remarks', 'created_at'];
    }

    public function j_business_plan(): BelongsTo
    {
        return $this->belongsTo(JBusinessPlan::class);
    }
}
