<?php

namespace App\Models\Base\Acl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
{
    use HasFactory;
}
