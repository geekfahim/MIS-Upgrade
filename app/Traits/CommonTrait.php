<?php

namespace App\Traits;

use App\Models\Base\Acl\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait CommonTrait
{
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getColumns($alias = null)
    {
        $columns = with(new static)->getFillable();
        array_push($columns, 'id');
        if ($alias) {
            return collect($columns)->map(fn($item) => $alias . '.' . $item)->all();
        }
        return $columns;
    }

    public function created_user(): HasOne
    {
        return $this->hasOne(User::class, "id", "created_by");
    }


    public function updated_user(): HasOne
    {
        return $this->hasOne(User::class, "id", "updated_by");
    }


    public function approved_user(): HasOne
    {
        return $this->hasOne(User::class, "id", "approved_by");
    }
}
