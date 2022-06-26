<?php

namespace App\Enums\IGA;

enum JSettlementStatus: string
{
    case Pending = 'Pending';
    case Confirmed = 'Confirmed';
    case Rejected = 'Rejected';
    case Approved = 'Approved';
}
