<?php

namespace Database\Seeders;

use App\Enums\IndicatorStatus;
use App\Enums\IndicatorType;
use App\Models\Jeebika\Settings\JIndicator;
use Illuminate\Database\Seeder;

class JIndicatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indicators = [
            //INSANIAT Family
            0 => ['id' => 1, 'name' => 'House', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Family->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            1 => ['id' => 2, 'name' => 'Food Assistance', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Family->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            2 => ['id' => 3, 'name' => 'Orphan Allowance', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Family->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //INSANIAT Member
            3 => ['id' => 4, 'name' => 'Regular Medicine', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Member->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            4 => ['id' => 5, 'name' => 'Clothing', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Member->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            5 => ['id' => 6, 'name' => 'Cataract', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Member->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            6 => ['id' => 7, 'name' => 'Hearing Aid', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Member->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            7 => ['id' => 8, 'name' => 'Disability Rehabilitation', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Member->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            8 => ['id' => 9, 'name' => 'Wearable Clothing', 'program_type' => 'INSANIAT', 'type' => IndicatorType::Member->value, 'sequence' => 1, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //JEEBIKA Family
            9 => ['id' => 10, 'name' => 'Investment Capital', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            10 => ['id' => 11, 'name' => 'Agriculture', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            11 => ['id' => 12, 'name' => 'Land', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            12 => ['id' => 13, 'name' => 'Cottage Industry', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            13 => ['id' => 14, 'name' => 'Production Machine', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            14 => ['id' => 15, 'name' => 'Cattle', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            15 => ['id' => 16, 'name' => 'Poultry', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            16 => ['id' => 17, 'name' => 'Small Business Capital', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            17 => ['id' => 18, 'name' => 'Agricultural Equipment', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Family->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //JEEBIKA Member
            18 => ['id' => 19, 'name' => 'Training', 'program_type' => 'JEEBIKA', 'type' => IndicatorType::Member->value, 'sequence' => 2, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //FERDOUSI Family
            19 => ['id' => 20, 'name' => 'First Aid', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            20 => ['id' => 21, 'name' => 'Complex', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            21 => ['id' => 22, 'name' => 'Medical', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            22 => ['id' => 23, 'name' => 'Emergency Medicine', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            23 => ['id' => 24, 'name' => 'Adolescent Health Education', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            24 => ['id' => 25, 'name' => 'Drug Supply', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            25 => ['id' => 26, 'name' => 'Pure Water', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            26 => ['id' => 27, 'name' => 'Healthy Latrine', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Family->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //FERDOUSI Member
            27 => ['id' => 28, 'name' => 'Pregnant Mother Service', 'program_type' => 'FERDOUSI', 'type' => IndicatorType::Member->value, 'sequence' => 3, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //GULBAGICHA Family
            //GULBAGICHA Member
            28 => ['id' => 29, 'name' => 'Child Education', 'program_type' => 'GULBAGICHA', 'type' => IndicatorType::Member->value, 'sequence' => 4, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            29 => ['id' => 30, 'name' => 'Education Assistance', 'program_type' => 'GULBAGICHA', 'type' => IndicatorType::Member->value, 'sequence' => 4, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            30 => ['id' => 31, 'name' => 'Textbooks', 'program_type' => 'GULBAGICHA', 'type' => IndicatorType::Member->value, 'sequence' => 4, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            31 => ['id' => 32, 'name' => 'Educational materials', 'program_type' => 'GULBAGICHA', 'type' => IndicatorType::Member->value, 'sequence' => 4, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            32 => ['id' => 33, 'name' => 'Baby clothes', 'program_type' => 'GULBAGICHA', 'type' => IndicatorType::Member->value, 'sequence' => 4, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            33 => ['id' => 34, 'name' => 'Nutritious food', 'program_type' => 'GULBAGICHA', 'type' => IndicatorType::Member->value, 'sequence' => 4, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            34 => ['id' => 35, 'name' => 'Quran education', 'program_type' => 'GULBAGICHA', 'type' => IndicatorType::Member->value, 'sequence' => 4, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],

            //EPIDEMIC Family
            35 => ['id' => 36, 'name' => 'Covid19 Safety', 'program_type' => 'EPIDEMIC', 'type' => IndicatorType::Family->value, 'sequence' => 5, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //EPIDEMIC Member
            36 => ['id' => 37, 'name' => 'Covid19 Vaccine', 'program_type' => 'EPIDEMIC', 'type' => IndicatorType::Member->value, 'sequence' => 5, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],

            //DISASTER Family
            37 => ['id' => 38, 'name' => 'Flood', 'program_type' => 'DISASTER', 'type' => IndicatorType::Family->value, 'sequence' => 6, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],
            //DISASTER Member
            38 => ['id' => 39, 'name' => 'Cold Blancket', 'program_type' => 'DISASTER', 'type' => IndicatorType::Member->value, 'sequence' => 6, 'status' => IndicatorStatus::Active->value, 'created_by' => 1, 'created_at' => now()],

        ];
        JIndicator::insert($indicators);
    }

}
