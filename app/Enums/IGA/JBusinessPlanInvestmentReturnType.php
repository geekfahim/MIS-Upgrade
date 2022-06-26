<?php

namespace App\Enums\IGA;

enum JBusinessPlanInvestmentReturnType: string
{
    case Weekly = 'Weekly';
    case Monthly = 'Monthly';
    case Yearly = 'Yearly';
    case OneTime = 'One Time';
}
