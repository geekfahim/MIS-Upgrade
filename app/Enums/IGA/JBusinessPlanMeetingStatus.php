<?php

namespace App\Enums\IGA;

enum JBusinessPlanMeetingStatus: string
{
    case Pending = 'Pending';
    case Hold = 'Hold';
    case Approved = 'Approved';
    case Rejected = 'Rejected';
}
