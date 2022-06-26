<?php

namespace App\Models\Jeebika\IGA\Business;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JBusinessPlanSource extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $casts = [
        'source_amount' => 'integer',
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d',
    ];
}
