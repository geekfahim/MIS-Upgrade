<?php

namespace Database\Seeders;

use App\Models\Jeebika\Training\JTraining;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //base
            UserTableSeeder::class,
            BankSeeder::class,
            DistrictSeeder::class,
            UpazilaSeeder::class,
            UnionSeeder::class,
            SponsorSeeder::class,
            AssetTypeSeeder::class,
            DisabilitySeeder::class,
            DisasterSeeder::class,
            DiseaseSeeder::class,
            OccupationSeeder::class,
            IncomeSeeder::class,
            RecoverSeeder::class,
            VocationalSeeder::class,
            SkillSeeder::class,
            //jeebika
            JIndicatorTableSeeder::class,
            JZoneSeeder::class,
            JAreaSeeder::class,
            JInvestmentAreaSeeder::class,
            JProjectSeeder::class,
            JGrosTableSeeder::class,
            //Demo Mustahiq
            MustahiqSeeder::class,
//            JBusinessSeeder::class,
            PermissionTableSeeder::class,
        ]);
        JTraining::factory(20)->create();
        $this->call([
            JTrainingParticipantTableSeeder::class
        ]);
    }
}
