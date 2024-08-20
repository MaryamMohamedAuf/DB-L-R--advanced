<?php
namespace Database\Factories;

use App\Models\FollowupSurvey;
use App\Models\Cohort;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowupSurveyFactory extends Factory
{
    protected $model = FollowupSurvey::class;

    public function definition()
    {
        // Get the last cohort id
        $lastCohortId = Cohort::latest('id')->value('id');

        return [
            'survey_id' => Survey::factory()->create()->id, // Create a new Survey and use its ID
            'cohort_id' => $lastCohortId, // Use the last cohort id
            'survey_tag' => $this->faker->word(),
            'date' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(['Completed', 'Pending', 'In Progress']),
        ];
    }
}
