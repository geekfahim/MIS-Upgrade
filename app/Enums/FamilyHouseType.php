<?php

namespace App\Enums;

enum FamilyHouseType: string
{
    case Building = 'Building';
    case BrickWallTinShade = 'BrickWall TinShade';
    case TinWallTinShade = 'TinWall TinShade';
    case RawHouse = 'Raw House';
    case HutHouse = 'Hut House';
    case MudHouse = 'Mud House';
}
