<?php

namespace Database\Factories\Jeebika\Training;

use App\Enums\JTrainingMethod;
use App\Enums\JTrainingStatus;
use App\Enums\JTrainingType;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Training\JTraining;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JTrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = JTraining::class;

    public function definition(): array
    {
        return [
            'training_heading'            => "Czm Training" . ' ' . $this->faker->numberBetween(1, 100),
            'training_location'           => $this->faker->city,
            'training_type'               => JTrainingType::Vocational,
            'training_method'             => JTrainingMethod::Offline,
            'j_project_id'                => JProject::inRandomOrder()->first(),
            'vocational_id'               => $this->faker->numberBetween(1, 5),
            'start_date'                  => $this->faker->dateTimeThisYear(),
            'end_date'                    => $this->faker->dateTimeThisMonth(),
            'resource_person_name'        => $this->faker->name,
            'resource_person_phone'       => $this->faker->numerify('017########'),
            'resource_person_designation' => $this->faker->jobTitle,
//            'status'                      => array_rand([JTrainingStatus::Upcoming, JTrainingStatus::Postponed, JTrainingStatus::Rejected]),
            'remarks'                     => $this->faker->sentence,
            'created_by'                  => 1

        ];
    }
}
