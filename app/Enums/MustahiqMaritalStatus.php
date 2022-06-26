<?php

namespace App\Enums;

enum MustahiqMaritalStatus: string
{
    case Unmarried = 'Unmarried';
    case Married = 'Married';
    case Widowed = 'Widowed';
    case Divorced = 'Divorced';
    case Separated = 'Separated';
}
