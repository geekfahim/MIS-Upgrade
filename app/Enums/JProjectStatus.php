<?php

namespace App\Enums;

enum JProjectStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Blocked = 'Blocked';
}
