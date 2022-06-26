<?php

namespace App\Enums;

enum JImplementationPlanStatus: string
{
    case Pending = 'Pending';
    case Implemented = 'Implemented';
    case Rejected = 'Rejected';
}
