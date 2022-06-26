<?php

namespace App\Enums;

enum IndicatorStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Blocked = 'Blocked';
}
