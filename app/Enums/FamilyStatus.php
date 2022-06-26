<?php

namespace App\Enums;

enum FamilyStatus: string
{
    case Pending = 'Pending';
    case Verified = 'Verified';
    case Rejected = 'Rejected';
    case Inactive = 'Inactive';
    case Active = 'Active';
    case Surrender = 'Surrender';
    case Graduate = 'Graduate';
}
