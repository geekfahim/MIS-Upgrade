<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Disability;
use Illuminate\Database\Seeder;

class DisabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['Autism or autism spectrum disorders', 'Mobility and Physical Impairments', 'Vision Disability', 'Hearing Disability', 'Psychological/Mental Disorders', 'cerebral palsy', 'down syndrome', 'multiple disability', 'Other Disability'];
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
            Disability::insert($chunk);
        }
    }
}
