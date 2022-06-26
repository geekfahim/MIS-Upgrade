<?php

namespace App\Enums\IGA;

enum JBPFeedbackFinalStatus: string
{
    case Pending = 'Pending';
    case Confirmed = 'Confirmed';
    case Approved = 'Approved';
    case Rejected = 'Rejected';
}
