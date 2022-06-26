<?php

namespace App\Enums\IGA;

enum JBusinessPlanStatus: string
{
    case Pending = 'Pending';
    case Hold = 'Hold';
    case Approved = 'Approved';
    case Ongoing = 'Ongoing';
    case Completed = 'Completed';
    case Rejected = 'Rejected';
}
