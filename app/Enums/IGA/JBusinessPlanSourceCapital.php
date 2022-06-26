<?php

namespace App\Enums\IGA;

enum JBusinessPlanSourceCapital: string
{
    case GroFund = 'GRO Fund';
    case JeebikaFamily = 'Jeebika Family';
    case SelfFund = 'Self Fund';
    case Relative = 'Relative';
    case Neighbour = 'Neighbour';
    case Others = 'Others';
}
