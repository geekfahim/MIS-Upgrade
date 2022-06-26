<?php

namespace App\Enums;

enum FamilyElectricityConnectivityType: string
{
    case HasElectricity = 'Has Electricity';
    case NoElectricity = 'No Electricity';
    case SolarElectricity = 'Solar Electricity';
    case BioElectricity = 'Bio Electricity';
}
