<?php

namespace Database\Factories;

use App\Models\Survey;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Survey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get the last cohort id
        $lastCohortId = Cohort::latest('id')->value('id');

        return [
            'cohort_id' => $lastCohortId, // Use the last cohort id
            'applicant_name' => $this->faker->name(),
            'company_name' => $this->faker->company(),
            'cohort_tag' => $this->faker->word(),
        ];
    }
}
