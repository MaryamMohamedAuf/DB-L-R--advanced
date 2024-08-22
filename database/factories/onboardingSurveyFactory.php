<?php

namespace Database\Factories;

use App\Models\OnboardingSurvey;
use App\Models\Cohort;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnboardingSurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnboardingSurvey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get the last cohort id
        $lastCohortId = Cohort::latest('id')->value('id');
        // Get a random survey id
        if (!$lastCohortId) {
            $lastCohortId = Cohort::factory()->create();
        }
        return [
            'survey_id' => Survey::factory()->create()->id, // Create a new Survey and use its ID
            'cohort_id' => $lastCohortId, // Use the last cohort id
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'material_due' => $this->faker->optional()->dateTime(),
        ];
    }
}
