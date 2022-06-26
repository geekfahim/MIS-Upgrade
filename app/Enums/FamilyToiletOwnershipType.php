<?php

namespace App\Enums;

enum FamilyToiletOwnershipType: string
{
    case Owned = 'Owned';
    case Joint = 'Joint';
    case OtherOwned = 'Other Owned';
    case None = 'None';
}
