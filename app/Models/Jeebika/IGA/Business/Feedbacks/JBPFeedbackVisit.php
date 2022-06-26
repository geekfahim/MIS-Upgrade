<?php

namespace App\Models\Jeebika\IGA\Business\Feedbacks;

use App\Enums\IGA\JBPFeedbackVisitBusinessStatus;
use App\Enums\IGA\JBPFeedbackVisitStatus;
use App\Models\Base\Acl\User;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JBPFeedbackVisit extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'business_status' => JBPFeedbackVisitBusinessStatus::class,
        'status' => JBPFeedbackVisitStatus::class,
        'visit_date' => 'immutable_date:Y-m-d',
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public static function listKey(): array
    {
        return ['id', 'visit_date', 'visit_id', 'business_status', 'status', 'created_at'];
    }

    public function j_business_plan(): BelongsTo
    {
        return $this->belongsTo(JBusinessPlan::class);
    }

    public function visit_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'visit_id', 'id');
    }
}
