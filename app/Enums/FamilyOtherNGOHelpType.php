<?php

namespace App\Enums;

enum FamilyOtherNGOHelpType: string
{
    case Health = 'Health';
    case Sanitation = 'Sanitation';
    case Disaster = 'Disaster';
    case Education = 'Education';
    case AgricultureCultivation = 'Agriculture Cultivation';
    case Other = 'Other';
}
