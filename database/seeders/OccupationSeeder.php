<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Occupation;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['Unemployed', 'Student', 'Beggar', 'Farmer with own land', 'Landless farmer', 'Day Labor', 'Housewife', 'Street Hawker', 'Rickshaw or Van Puller', 'Small Business', 'Village Doctor', 'Stay outside the country', 'Tailor', 'Teacher', 'Driver', 'Imam or Muezzin', 'Retirement from job', 'Govt Services', 'Private Services'];
        $maxCount = count($item);
        for ($i = 0; $i < $maxCount; $i++) {
            $data[] = [
                'name'       => $item[$i],
                'created_by' => 1,
                'created_at' => now(),
            ];
        }
        $chunks = array_chunk($data, $maxCount);
        foreach ($chunks as $chunk) {
            Occupation::insert($chunk);
        }
    }
}
