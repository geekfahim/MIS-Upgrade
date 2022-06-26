<?php

namespace App\Enums;

enum FamilyRichHelpType: string
{
    case OccasionalFinancialHelp = 'Occasional Financial Help';
    case HelpInDisaster = 'Help in Disaster';
    case ZakatSadaqahCharity = 'Zakat Sadaqah Charity';
    case FoodSupport = 'Food Support';
    case WinterClothes = 'Winter Clothes';
    case Treatment = 'Treatment';
    case ReligiousFestival = 'Religious Festival';
    case Other = 'Other';
}
