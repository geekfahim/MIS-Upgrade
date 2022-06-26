<?php

namespace App\Enums;

enum JHealthSessionStatus: string
{
    case Upcoming = 'Upcoming';
    case Complete = 'Complete';
    case Postponed = 'Postponed';
    case Rejected = 'Rejected';
}
