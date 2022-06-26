<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['Cancer', 'Respiratory Infections', 'Gastric Ulcer', 'Heart Disease', 'Stroke', 'Birth Complications', 'Tuberculosis (TB)', 'Diabetes', 'Liver Cirrhosis'];
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
            Disease::insert($chunk);
        }
    }
}
