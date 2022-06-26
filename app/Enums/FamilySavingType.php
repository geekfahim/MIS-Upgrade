<?php

namespace App\Enums;

enum FamilySavingType: string
{
    case Home = 'Home';
    case Bank = 'Bank';
    case PostOffice = 'Post Office';
    case Insurance = 'Insurance';
    case NGO = 'NGO';
    case Samity = 'Samity';
    case GiveLoan = 'Give Loan';
}
