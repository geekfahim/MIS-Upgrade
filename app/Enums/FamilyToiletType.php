<?php

namespace App\Enums;

enum FamilyToiletType: string
{
    case Bathroom = 'Bathroom';
    case RingSlabWaterproof = 'Ring Slab Waterproof';
    case RingSlabNonWaterproof = 'Ring Slab Non Waterproof';
    case Hanging = 'Hanging';
    case OpenSpace = 'Open Space';
}
