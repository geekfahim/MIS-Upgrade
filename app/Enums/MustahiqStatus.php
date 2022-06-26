<?php

namespace App\Enums;

enum MustahiqStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Blocked = 'Blocked';
}
