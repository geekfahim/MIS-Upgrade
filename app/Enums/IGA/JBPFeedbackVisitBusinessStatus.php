<?php

namespace App\Enums\IGA;

enum JBPFeedbackVisitBusinessStatus: string
{
    case NotStarted = 'Not Started';
    case Started = 'Started';
    case InProfit = 'In Profit';
    case InLoss = 'In Loss';
    case CapitalLoss = 'Capital Loss';
    case BreakEven = 'Break Even';
}
