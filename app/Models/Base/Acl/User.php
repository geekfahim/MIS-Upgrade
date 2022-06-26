<?php

namespace App\Models\Base\Acl;

use App\Enums\UserStatus;
use App\Models\Jeebika\IGA\Business\Feedbacks\JBPFeedbackVerification;
use App\Models\Jeebika\Project\JProject;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use CommonTrait, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'office_id',
        'mobile',
        'email',
        'password',
        'status',
        'is_admin',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'immutable_date:Y-m-d',
        'updated_at' => 'immutable_date:Y-m-d',
        'is_admin' => 'boolean',
        'office_id' => 'integer',
        'status' => UserStatus::class,
    ];

    public static function getAllWithOfficeID(UserStatus $status = UserStatus::Active)
    {
        return self::getAll(status: $status)->map(fn($item) => ['id' => $item->id, 'text' => $item->name . ' (' . $item->office_id . ')']);
    }

    public static function getAll(mixed $selected = "*", UserStatus $status = UserStatus::Active, bool $role = false, $ids = null)
    {
        return static::select($selected)->where('status', $status)->where('is_admin', $role)->when($ids, fn($builder) => $builder->whereIn('id', $ids))->get();
    }

    public function password(): Attribute
    {
        return new Attribute(set: fn($value) => bcrypt($value));
    }

    public function manager(): HasOne
    {
        return $this->hasOne(JProject::class, 'manager_id');
    }

    public function visitBy(): HasOne
    {
        return $this->hasOne(JBPFeedbackVerification::class);
    }
}
