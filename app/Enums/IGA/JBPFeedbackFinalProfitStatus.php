<?php

namespace App\Enums\IGA;

enum JBPFeedbackFinalProfitStatus: string
{
    case Profit = 'Profit';
    case Loss = 'Loss';
    case BreakEven = 'Break Even';
}
