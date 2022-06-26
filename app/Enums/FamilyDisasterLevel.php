<?php

namespace App\Enums;

enum FamilyDisasterLevel: string
{

    const LEVELS = [1 => 'Minor', 2 => 'Major', 3 => 'Extreme'];

    case Minor = 'Minor';
    case Major = 'Major';
    case Extreme = 'Extreme';
}
