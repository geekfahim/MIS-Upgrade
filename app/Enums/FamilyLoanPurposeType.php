<?php

namespace App\Enums;

enum FamilyLoanPurposeType: string
{
    case NotInvestYet = 'Not Invest Yet';
    case BuyLand = 'Buy Land';
    case TakeLandMortgage = 'Take Land Mortgage';
    case InvestCurrentBusiness = 'Invest Current Business';
    case InvestNewBusiness = 'Invest New Business';
    case BuyCowBuffalo = 'Buy Cow Buffalo';
    case BuyGoatSheep = 'Buy Goat Sheep';
    case StockGoods = 'Stock Goods';
    case BuyDuckChicken = 'Buy Duck Chicken';
    case BuyBoat = 'Buy Boat';
    case FishingNet = 'Fishing Net';
    case BuyMechanicalTools = 'Buy Mechanical Tools';
    case BuyRickshawVanAutoCNG = 'Buy Rickshaw Van Auto CNG';
    case FamilyLiving = 'Family Living';
    case MedicalTreatment = 'Medical Treatment';
    case BuildNewHouse = 'Build New House';
    case RepairHouse = 'Repair House';
    case Bribe = 'Bribe';
    case Dowry = 'Dowry';
    case CultivateLand = 'Cultivate Land';
    case GoAbroad = 'Go Abroad';
    case Other = 'Other';
}
