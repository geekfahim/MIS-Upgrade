<?php

namespace App\Enums\IGA;

enum JBPFeedbackVerificationStatus: string
{
    case Pending = 'Pending';
    case Confirmed = 'Confirmed';
    case Approved = 'Approved';
    case Rejected = 'Rejected';
}
