<?php

namespace App\Enums;

enum FamilyRelationType: string
{
    case Self = 'Self';
    case Father = 'Father';
    case Mother = 'Mother';
    case Son = 'Son';
    case Daughter = 'Daughter';
    case Brother = 'Brother';
    case Sister = 'Sister';
    case Husband = 'Husband';
    case Wife = 'Wife';
    case GrandFather = 'Grand Father';
    case GrandMother = 'Grand Mother';
}
