<?php

namespace App\Enums;

enum FamilySafetyAbuserRelationType: string
{
    case Husband = 'Husband';
    case FatherInLaw = 'Father in Law';
    case MotherInLaw = 'Mother in Law';
    case Cousins = 'Cousins';
    case Neighbor = 'Neighbor';
    case Classmate = 'Classmate';
    case FatherMother = 'Father Mother';
    case Siblings = 'Siblings';
}
