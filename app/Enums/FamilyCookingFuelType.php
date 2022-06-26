<?php

namespace App\Enums;

enum FamilyCookingFuelType: string
{
    case WoodStraw = 'Wood Straw';
    case CylinderGas = 'Cylinder Gas';
    case BioGas = 'Bio Gas';
    case LineGas = 'Line Gas';
    case Electricity = 'Electricity';
}
