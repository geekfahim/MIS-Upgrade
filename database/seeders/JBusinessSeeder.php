<?php

namespace Database\Seeders;

use App\Enums\IGA\JBusinessPlanInvestmentReturnType;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Enums\SponsorStatus;
use App\Enums\SponsorType;
use App\Models\Base\Settings\Sponsor;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\IGA\Business\JBusinessPlanFamily;
use App\Models\Jeebika\Jeebika;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Str;

class JBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jeebika = Jeebika::where('j_project_id', 1)->where('j_gro_id', 1)->firstOrFail();
        $names = ['Beef Fattening', 'Chicken and Hen', 'Duck', 'Agri Land Cultivation', 'Potato Cultivation', 'Wheat Cultivation', 'Rice Cultivation'];
        $assists = ['FATHER', 'MOTHER', 'SON', 'DAUGHTER', 'BROTHER', 'SISTER', 'HUSBAND', 'WIFE', 'GRAND_FATHER', 'GRAND_MOTHER'];
        $maxCount = 30;
        for ($i = 1; $i <= $maxCount; $i++) {
            $status = Arr::random(JBusinessPlanStatus::cases());
            $isPositive = in_array($status->value, ['Approved', 'Ongoing', 'Completed']);
            $areaId = rand(1, 5);
            $isBusinessEx = rand(0, 1);
            $isTraining = rand(0, 1);
            $bp = JBusinessPlan::create([
                'j_project_id' => $jeebika->j_project_id,
                'j_gro_id' => $jeebika->j_gro_id,
                'family_id' => $jeebika->family_id,
                'is_joint' => $i < 10,
                'business_name' => "{$names[array_rand($names)]} {$i}",
                'j_investment_area_id' => $areaId,
                'business_duration' => rand(6, 30),
                'business_seed_money' => rand(50000, 70000),
                'possible_gross_income' => rand(50000, 70000),
                'possible_gross_expense' => rand(50000, 70000),
                'investment_return_type' => Arr::random(JBusinessPlanInvestmentReturnType::cases()),
                'investment_return_amount_each' => rand(100, 5000),
                'business_assist' => $assists[array_rand($assists)],
                'possible_net_profit' => rand(1000, 50000),
                'is_business_experience' => $isBusinessEx,
                'business_experience_duration' => $isBusinessEx ? rand(10, 50) : 0,
                'is_business_training' => $isTraining,
                'business_training_duration' => $isTraining ? rand(10, 50) : 0,
                'business_training_institute_name' => $isTraining ? Str::random(20) : null,
                'is_valid_information' => rand(0, 1),
                'is_previous_installment' => rand(0, 1),
                'is_proposed_business_skill_and_experience' => rand(0, 1),
                'is_general_savings' => rand(0, 1),
                'is_recommended' => rand(0, 1),
                'recommendation_remarks' => Str::random(50),
                'meeting_date' => date('Y-m-d', strtotime('+' . mt_rand(0, 30) . ' days')),
                'meeting_status' => $isPositive ? 'Approved' : $status->value,
                'approved_amount' => $isPositive ? rand(50000, 70000) : null,
                'approved_investment_return_type' => $isPositive ? Arr::random(JBusinessPlanInvestmentReturnType::cases()) : null,
                'disbursement_date' => $isPositive ? date('Y-m-d', strtotime('+' . mt_rand(0, 30) . ' days')) : null,
                'approved_investment_area_id' => $isPositive ? $areaId : null,
                'disbursement_amount' => $isPositive ? rand(50000, 70000) : null,
                'gro_remarks' => Str::random(100),
                'status' => $status,
                'created_by' => 1,
                'created_at' => now(),
            ]);
            JBusinessPlanFamily::create([
                'j_business_plan_id' => $bp->id,
                'j_project_id' => $bp->j_project_id,
                'j_gro_id' => $bp->j_gro_id,
                'family_id' => $bp->family_id,
                'created_by' => 1,
                'created_at' => now(),
            ]);
        }


        for ($i = 20; $i <= 30; $i++) {
            $data[] = [
                'name' => "Test Sponsor Delete $i",
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
