<?php

namespace Database\Seeders;

use App\Models\Base\Acl\User;
use App\Models\Base\Settings\Sponsor;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Seeder;

class JProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'JUK Amishapara, Sonaimuri', 'manager_id' => 2, 'district_id' => 5, 'j_zone_id' => 4, 'j_area_id' => 1, 'number_of_household_cover' => 500, 'start_date' => '2022-05-01', 'end_date' => '2022-05-31', 'status' => 'Active'],
            ['name' => 'JUK Austrogram, Kishoreganj', 'manager_id' => 8, 'district_id' => 45, 'j_zone_id' => 2, 'j_area_id' => 3, 'number_of_household_cover' => 500, 'start_date' => '2022-05-01', 'end_date' => '2022-05-31', 'status' => 'Active'],
            ['name' => 'JUK Baraongaon, Sonaimuri', 'manager_id' => 10, 'district_id' => 5, 'j_zone_id' => 4, 'j_area_id' => 1, 'number_of_household_cover' => 500, 'start_date' => '2022-05-01', 'end_date' => '2022-05-31', 'status' => 'Active'],
            ['name' => 'JUK Bikrampur, Munshiganj', 'manager_id' => 18, 'district_id' => 48, 'j_zone_id' => 2, 'j_area_id' => 3, 'number_of_household_cover' => 500, 'start_date' => '2022-05-01', 'end_date' => '2022-05-26', 'status' => 'Active']

        ];
        $maxCount = count($items);
        for ($i = 0; $i < $maxCount; $i++) {
            $project = JProject::create([
                'name' => $items[$i]['name'],
                'district_id' => $items[$i]['district_id'],
                'manager_id' => $items[$i]['manager_id'],
                'j_zone_id' => $items[$i]['j_zone_id'],
                'j_area_id' => $items[$i]['j_area_id'],
                'start_date' => $items[$i]['start_date'],
                'end_date' => $items[$i]['end_date'],
                'number_of_household_cover' => $items[$i]['number_of_household_cover'],
                'status' => $items[$i]['status'],
                'created_by' => 1,
                'created_at' => now(),
            ]);
            $sponsors = Sponsor::take(rand(1, Sponsor::count()))->get();
            foreach ($sponsors as $sponsor) {
                $project->sponsors()->create([
                    'sponsor_id' => $sponsor->id,
                    'created_by' => 1,
                    'created_at' => now(),
                ]);
            }
            $fieldOfficers = User::where('is_admin', false)->take(rand(1, User::count()))->get();
            foreach ($fieldOfficers as $fieldOfficer) {
                $project->field_officers()->create([
                    'officer_id' => $fieldOfficer->id,
                    'created_by' => 1,
                    'created_at' => now(),
                ]);
            }
        }
    }


    /*Previous seeder*/
    /*    public function old_run()
        {
            $district = District::findOrFail(47); //district 47 is Dhaka
            $manager = User::find(2); //user 2 is CEO
            $zone = JZone::inRandomOrder()->first();
            $project = JProject::create([
                'name'                      => "Test Project - {$district->name} - {$manager->name}",
                'district_id'               => $district->id,
                'manager_id'                => $manager->id,
                'j_zone_id'                 => $zone->id,
                'j_area_id'                 => $zone->j_area()->inRandomOrder()->first()->id,
                'start_date'                => now(),
                'end_date'                  => now()->addYears(rand(3, 5)),
                'number_of_household_cover' => rand(400, 500),
                'status'                    => JGroStatus::Active,
                'created_by'                => 1,
                'created_at'                => now(),
            ]);
            $sponsors = Sponsor::take(4)->get();
            foreach ($sponsors as $sponsor) {
                $project->sponsors()->create([
                    'sponsor_id' => $sponsor->id,
                    'created_by' => 1,
                    'created_at' => now(),
                ]);
            }
            $fieldOfficers = User::where('is_admin', false)->take(4)->get();
            foreach ($fieldOfficers as $fieldOfficer) {
                $project->field_officers()->create([
                    'officer_id' => $fieldOfficer->id,
                    'created_by' => 1,
                    'created_at' => now(),
                ]);
            }
            //Other Projects and its sponsors
            for ($i = 3; $i <= 11; $i++) {
                $district = District::findOrFail($i);
                $manager = User::findOrFail($i);
                $zone = JZone::inRandomOrder()->first();
                $project = JProject::create([
                    'name'                      => "Test Project - {$district->name} - {$manager->name}",
                    'district_id'               => $district->id,
                    'manager_id'                => $manager->id,
                    'j_zone_id'                 => $zone->id,
                    'j_area_id'                 => $zone->j_area()->inRandomOrder()->first()->id,
                    'start_date'                => now(),
                    'end_date'                  => now()->addYears(rand(3, 5)),
                    'number_of_household_cover' => rand(400, 500),
                    'status'                    => JGroStatus::Active,
                    'created_by'                => 1,
                    'created_at'                => now(),
                ]);
                $sponsors = Sponsor::take(rand(1, Sponsor::count()))->get();
                foreach ($sponsors as $sponsor) {
                    $project->sponsors()->create([
                        'sponsor_id' => $sponsor->id,
                        'created_by' => 1,
                        'created_at' => now(),
                    ]);
                }
                $fieldOfficers = User::where('is_admin', false)->take(rand(1, User::count()))->get();
                foreach ($fieldOfficers as $fieldOfficer) {
                    $project->field_officers()->create([
                        'officer_id' => $fieldOfficer->id,
                        'created_by' => 1,
                        'created_at' => now(),
                    ]);
                }
            }
        }*/


}
