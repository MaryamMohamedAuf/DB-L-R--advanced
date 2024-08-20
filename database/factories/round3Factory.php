<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\Factory;

class Round3Factory extends Factory
{
    protected $model = \App\Models\Round3::class;

    public function definition()
    {
        return [
            'applicant_id' => Applicant::factory(), // Create a new Applicant and use its ID
            'cohort_id' => Cohort::latest('id')->value('id'), // Use the latest cohort id
            'final_decision' => $this->faker->boolean,
            'recorded_meeting_link' => $this->faker->optional()->url,
        ];
    }
}
