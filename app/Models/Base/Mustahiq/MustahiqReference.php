<?php

namespace App\Models\Base\Mustahiq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MustahiqReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'mustahiq_id',
        'mustahiq_name',
        'evaluation_name',
        'name',
        'relationship',
        'mobile',
        'email',
        'address',
        'created_by',
        'updated_by',
    ];
}
