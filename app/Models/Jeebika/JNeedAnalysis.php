<?php

namespace App\Models\Jeebika;

use Illuminate\Database\Eloquent\Model;

class JNeedAnalysis extends Model
{
    public $timestamps = false;

    public static function me()
    {
        return with(new static)->getTable();
    }
}
