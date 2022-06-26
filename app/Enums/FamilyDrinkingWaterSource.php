<?php

namespace App\Enums;

enum FamilyDrinkingWaterSource: string
{
    case DeepTubeWell = 'Deep Tube Well';
    case NormalTubeWell = 'Normal Tube Well';
    case SupplyWater = 'Supply Water';
    case RainWater = 'Rain Water';
    case RiverCanal = 'River Canal';
    case PondWater = 'Pond Water';
    case WellFountain = 'Well Fountain';
}
