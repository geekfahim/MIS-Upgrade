<?php

namespace Database\Seeders;

use App\Models\Jeebika\Training\JTrainingMustahiq;
use Illuminate\Database\Seeder;

class JTrainingParticipantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'j_training_id' => 1,
                'mustahiq_id'   => $i,
                'created_by'    => 1,
                'created_at'    => now(),
            ];
        }
        $chunks = array_chunk($data, 10);
        foreach ($chunks as $chunk) {
            JTrainingMustahiq::insert($chunk);
        }
    }
}
