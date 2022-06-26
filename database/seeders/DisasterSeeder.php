<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Disaster;
use Illuminate\Database\Seeder;

class DisasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['Flood', 'Doughty', 'Cyclone', 'River erosion', 'Heavy rain', 'Waterlogging', 'Death of main income person', 'Illness of main come person', 'Separation', "Theft'/'robbery", 'Land robbery,Domestic animals die', 'Domesticated', 'poultry die,Dowry'];
        $maxCount = count($item);
        for ($i = 0; $i < $maxCount; $i++) {
            $data[] = [
                'name' => $item[$i],
                'created_by' => 1,
                'created_at' => now(),
            ];
        }
        $chunks = array_chunk($data, $maxCount);
        foreach ($chunks as $chunk) {
            Disaster::insert($chunk);
        }
    }
}
