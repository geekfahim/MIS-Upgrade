<?php

namespace App\Models\Jeebika\IGA;

use App\Models\Base\Family\Family;
use App\Models\Jeebika\Jeebika;

class BalanceUpdate {
    public static function update(int $fid,int $amount,bool $credit=true) {
        $balance = JFamilyBalance::firstWhere('family_id', $fid);
        if (!$balance) {
            $jeebika = Jeebika::firstWhere('family_id', $fid);
            JFamilyBalance::create([
                'j_project_id' => $jeebika->j_project_id,
                'j_gro_id'     => $jeebika->j_project_id,
                'family_id'    => $fid,
                'balance'      => $credit ? $amount : -$amount,
            ]);
            return;
        }

        if ($credit) {
            $balance->balance += $amount;
        } else {
            $balance->balance -= $amount;
        }
        $balance->save();
    }
}
