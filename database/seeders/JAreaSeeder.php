<?php

namespace Database\Seeders;

use App\Models\Jeebika\Settings\JArea;
use Illuminate\Database\Seeder;

class JAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['South East', 'South West', 'North East', 'North West'];
        $maxCount = count($item);
        for ($i = 0; $i < $maxCount; $i++) {
            $data[] = [
                'name'       => $item[$i],
                'manager_id' => $i + 1,
                'j_zone_id'  => $i + 1,
                'created_by' => 1,
                'created_at' => now(),
            ];
        }
        $chunks = array_chunk($data, $maxCount);
        foreach ($chunks as $chunk) {
            JArea::insert($data);
        }
    }
}
