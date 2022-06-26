<?php

namespace App\Enums;

enum FamilyHouseLandType: string
{
    case SelfOwned = 'Self Owned';
    case OtherOwned = 'Other Owner';
    case Government = 'Government';
    case Rented = 'Rented';
}
