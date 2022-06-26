<?php

namespace App\Enums;

enum SponsorStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Blocked = 'Blocked';
}
