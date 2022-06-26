<?php

namespace Database\Seeders;

use App\Enums\SponsorStatus;
use App\Enums\SponsorType;
use App\Models\Base\Settings\Sponsor;
use Arr;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'name' => "Test Sponsor $i",
                'type' => Arr::random(SponsorType::cases()),
                'mobile' => random_int(11111111111, 99999999999),
                'status' => SponsorStatus::Active,
                'created_by' => 1,
                'created_at' => now(),
            ];
        }
        $chunks = array_chunk($data, 10);
        foreach ($chunks as $chunk) {
            Sponsor::insert($chunk);
        }
    }
}
