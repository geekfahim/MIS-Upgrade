<?php

namespace App\Enums;

enum FamilyConflictResolveType: string
{
    case Thana = 'Thana';
    case VillageHead = 'Village Head';
    case UPChairman = 'UP Chairman';
    case UPMemberCouncilor = 'UP Member Councilor';
    case Imam = 'Imam';
    case Neighbor = 'Neighbor';
    case PoliticalLeader = 'Political Leader';
    case Other = 'Other';
}
