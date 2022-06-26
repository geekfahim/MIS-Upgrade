<?php

namespace App\Models\Base\Settings;

use App\Enums\SponsorStatus;
use App\Enums\SponsorType;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use CommonTrait, HasFactory, SoftDeletes;

    protected $casts = [
        'status' => SponsorStatus::class,
        'type' => SponsorType::class,
        'mobile' => 'integer',
        'contact_person_mobile' => 'integer',
        'created_at' => 'immutable_datetime:Y-m-d',
        'updated_at' => 'immutable_datetime:Y-m-d',
    ];

    public static function listKey(): array
    {
        return ['id', 'name', 'type', 'status', 'created_at'];
    }

    public static function getAll($selected = "*", SponsorStatus $status = SponsorStatus::Active)
    {
        return static::select($selected)->where('status', $status)->orderBy("name")->get();
    }

    public static function getRowById($id, $selected = "*", SponsorStatus $status = SponsorStatus::Active)
    {
        return static::select($selected)->where('status', $status)->findOrFail($id);
    }
}
