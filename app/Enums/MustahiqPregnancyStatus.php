<?php

namespace App\Enums;

enum MustahiqPregnancyStatus: string
{
    case None = 'None';
    case Pregnant = 'Pregnant';
    case Lactating = 'Lactating';
    case Both = 'Both';
}
