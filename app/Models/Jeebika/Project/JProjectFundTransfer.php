<?php

namespace App\Models\Jeebika\Project;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JProjectFundTransfer extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $fillable = [
        'j_project_id',
        'date',
        'amount',
        'remarks',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $casts = [
        'amount'     => 'integer',
        'date'       => 'immutable_date:Y-m-d',
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
    ];
}
