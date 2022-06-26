<?php

namespace App\Enums;

enum FamilyExpenseType: string
{
    case Food = 'Food';
    case Education = 'Education';
    case HealthTreatment = 'Health Treatment';
    case WaterSanitation = 'Water Sanitation';
    case Clothing = 'Clothing';
    case Interest = 'Interest';
    case Accident = 'Accident';
    case UtilityBill = 'Utility Bill';
    case HouseRent = 'House Rent';
    case Savings = 'Savings';
}
