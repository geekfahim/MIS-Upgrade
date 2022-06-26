<?php

namespace App\Enums;

enum MustahiqRelationalLivingStatus: string
{
    case Alive = 'Alive';
    case Dead = 'Dead';
    case Divorced = 'Divorced';
    case Separated = 'Separated';
}
