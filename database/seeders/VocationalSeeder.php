<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Vocational;
use Illuminate\Database\Seeder;

class VocationalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = ['Driving', 'Mechanic', 'Tailoring', 'Electrician', 'Heating Technician', 'AC Technician', 'Refrigeration Technician', 'TV Technician'];
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
            Vocational::insert($chunk);
        }
    }
}
