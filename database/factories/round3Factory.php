<?php

namespace Database\Factories;

use App\Models\Round2;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\Factory;

class Round3Factory extends Factory
{
    protected $model = \App\Models\Round3::class;

    public function definition()
    {
        // $applicant = Round2::inRandomOrder()->first();
        // if (!$applicant) {
        //     $applicant = Round2::factory()->create();
        // }
        $lastCohortId = Cohort::latest('id')->value('id');

        if (!$lastCohortId) {
            $lastCohortId = Cohort::factory()->create();
        }
            $applicant = Round2::inRandomOrder()->first();
            
            // If there are no applicants, create one
            if (!$applicant) {
                $applicant = Round2::factory()->create();
            }
    
           
        return [
            'applicant_id' => $applicant->applicant_id,
            'cohort_id' => $lastCohortId, // Use the latest cohort id
            'final_decision' => $this->faker->boolean,
            'recorded_meeting_link' => $this->faker->optional()->url,
        ];
    }
}
