<?php

namespace Database\Factories;

use App\Models\Survey;
use App\Models\Cohort;
use App\Models\applicant;

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
       // $cohort = Cohort::inRandomOrder()->first();
        $lastCohortId = Cohort::latest('id')->value('id');

        if (!$lastCohortId) {
            $lastCohortId = Cohort::factory()->create();
        }
        $applicant = Applicant::inRandomOrder()->first();
        
        if (!$applicant) {
            $applicant = Applicant::factory()->create();
        }
        return [
            'cohort_id' => $lastCohortId, // Use the last cohort id
            'applicant_name' => $this->faker->name(),
            'company_name' => $applicant->company_name,
            'cohort_tag' => $this->faker->word(),
        ];
    }
}
