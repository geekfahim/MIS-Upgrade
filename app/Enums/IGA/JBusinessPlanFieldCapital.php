<?php

namespace App\Enums\IGA;

enum JBusinessPlanFieldCapital: string
{
    case ProductPurchase = 'Product Purchase';
    case Infrastructure = 'Infrastructure';
    case Management = 'Management';
    case Food = 'Food';
    case Health = 'Health';
    case Others = 'Others';
}
