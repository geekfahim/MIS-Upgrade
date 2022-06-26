<?php

namespace App\Models\Base\Settings;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Union extends Model
{
    use HasFactory, CommonTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'upazila_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }
}
