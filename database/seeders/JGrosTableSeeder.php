<?php

namespace Database\Seeders;

use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Bank;
use App\Models\Base\Settings\District;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class JGrosTableSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $groNames = ['Shapla', 'Joba', 'Golap', 'Jui', 'Bely', 'Chompa'];
        foreach (JProject::get() as $jProject) {
            $limit = rand(3, 5);
            for ($j = 1; $j <= $limit; $j++) {
                $data[] = [
                    'name'                => Arr::random($groNames),
                    'j_project_id'        => $jProject->id,
                    'reference_id'        => random_int(12121212, 89898989),
                    'number_of_family'    => 30,
                    'bank_id'             => Bank::inRandomOrder()->first()->id,
                    'bank_branch_name'    => District::inRandomOrder()->first()->name . ' Branch',
                    'bank_account_number' => random_int(1111111111111, 9999999999999),
                    'created_by'          => 1,
                    'created_at'          => now(),
                ];
            }
        }
        $chunks = array_chunk($data, 10);
        foreach ($chunks as $chunk) {
            JGro::insert($chunk);
        }
    }
}
