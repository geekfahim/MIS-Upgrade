<?php

namespace App\Enums;

enum FamilyLoanSourceType: string
{
    case Bank = 'Bank';
    case NGO = 'NGO';
    case Samity = 'Samity';
    case RelativeNeighbour = 'Relative Neighbour';
    case Mortgage = 'Mortgage';
    case Other = 'Other';
}
