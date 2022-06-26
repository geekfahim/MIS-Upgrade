<?php

namespace Database\Seeders;

use App\Models\Base\Settings\Recover;
use Illuminate\Database\Seeder;

class RecoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $item = ['Borrow loan', 'Sale land', 'Land mortgage', 'Advance labor sale', 'Advance labor sale', 'Investing less on food', 'Sale other assets', 'Help from relatives', 'Other way', 'Not recovered'];
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
            Recover::insert($chunk);
        }
    }
}
