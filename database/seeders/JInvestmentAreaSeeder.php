<?php

namespace Database\Seeders;

use App\Models\Jeebika\Settings\JInvestmentArea;
use Illuminate\Database\Seeder;

class JInvestmentAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Manufacturer', 'Buy and Sell', 'Farm', 'Rickshaw', 'Van', 'Agriculture'];
        $count = count($names);
        for ($i = 0; $i < $count; $i++) {
            JInvestmentArea::create([
                'name' => $names[$i],
                'created_by' => 1,
                'created_at' => now(),
            ]);
        }
    }
}
