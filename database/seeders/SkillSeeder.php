<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = ['Beef Fattening', 'Fish Cultivation', 'Farming', 'Teacher', 'Milk Harvesting', 'Goat Farming', 'Paddy Cultivation', 'Wheat Cultivation'];
        $maxCount = count($item);
        $data = [];
        for ($i = 0; $i < $maxCount; $i++) {
            $data[] = [
                'name' => $item[$i],
                'created_by' => 1,
                'created_at' => now(),
            ];
        }
        $chunks = array_chunk($data, $maxCount);
        foreach ($chunks as $chunk) {
            Skill::insert($chunk);
        }
    }
}
