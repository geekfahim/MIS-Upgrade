<?php

namespace App\Enums;

enum JGroStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Blocked = 'Blocked';
}
