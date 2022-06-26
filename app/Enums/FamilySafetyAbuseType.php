<?php

namespace App\Enums;

enum FamilySafetyAbuseType: string
{
    case Abusive = 'Abusive';
    case Beating = 'Beating';
    case SexualHarassment = 'Sexual Harassment';
    case Propaganda = 'Propaganda';
    case Slander = 'Slander';
    case Other = 'Other';
}
