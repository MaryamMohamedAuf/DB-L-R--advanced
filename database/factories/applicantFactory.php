<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Applicant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastCohortId = Cohort::latest('id')->value('id');
        if (!$lastCohortId) {
            $lastCohortId = Cohort::factory()->create();
        }
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'company_name' => $this->faker->company(),
            'cohort_id' => $lastCohortId, // Generates a cohort if not provided
        ];
    }
}
