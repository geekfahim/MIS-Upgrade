<?php

namespace App\Models\Base\Mustahiq;

use App\Models\Base\Settings\Vocational;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MustahiqVocational extends Model
{
    use CommonTrait, HasFactory, SoftDeletes;

    public function vocational(): BelongsTo
    {
        return $this->belongsTo(Vocational::class);
    }
}

