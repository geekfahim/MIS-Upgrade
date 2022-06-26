<?php

namespace App\Enums;

enum JTrainingStatus: string
{
    case Upcoming = 'Upcoming';
    case Complete = 'Complete';
    case Postponed = 'Postponed';
    case Rejected = 'Rejected';
}
