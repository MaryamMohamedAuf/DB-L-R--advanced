<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\Factory;

class Round2Factory extends Factory
{
    protected $model = \App\Models\Round2::class;

    public function definition()
    {
        // Get the last cohort id
        $lastCohortId = Cohort::latest('id')->value('id');

        return [
            'applicant_id' => Applicant::factory(), // Create a new Applicant and use its ID
            'cohort_id' => $lastCohortId, // Use the last cohort id
            'phone' => $this->faker->phoneNumber,
            'One_Sentence_Description' => $this->faker->sentence,
            'sector' => $this->faker->word,
            'other_sector' => $this->faker->optional()->word,
            'business_model' => $this->faker->word,
            'other_business_model' => $this->faker->optional()->word,
            'solution' => $this->faker->word,
            'other_solution' => $this->faker->optional()->word,
            'demo_url' => $this->faker->optional()->url,
            'traction' => $this->faker->word,
            'where_customer_find_solution' => $this->faker->word,
            'revenue_generated' => $this->faker->word,
            'funding_received' => $this->faker->word,
            'other_funding_type' => $this->faker->optional()->word,
            'sources_of_funding' => implode(',', $this->faker->randomElements(['Grant', 'Investment', 'Revenue', 'Loan'], 2, false)),
            'core_team_members' => $this->faker->numberBetween(1, 10),
            'previous_startup_experience' => $this->faker->boolean,
            'core_team' => $this->faker->optional()->sentence,
            'core_team_experience' => $this->faker->optional()->sentence,
            'employees_full_time_part_time_interns' => $this->faker->word,
            'positions_to_fill' => $this->faker->optional()->word,
            'goals_next_3_to_12_months' => $this->faker->paragraph,
            'prex_program_expectations' => $this->faker->paragraph,
            'accomplish_within_year' => implode(',', $this->faker->randomElements(['Revenue Growth', 'Market Expansion', 'Product Development'], 2, false)),
            'submit_pitch_video_url' => $this->faker->url,
            'covid19_resilience_impact' => $this->faker->optional()->word,
            'social_impact' => $this->faker->word,
            'covid19_impact' => implode(',', $this->faker->randomElements(['Positive', 'Negative', 'Neutral'], 2, false)),
            'other_covid19_impact' => $this->faker->word,
            'critical_support_resource' => implode(',', $this->faker->randomElements(['Funding', 'Mentorship', 'Networking'], 2, false)),
            'best_support_resource' => implode(',', $this->faker->randomElements(['Advisors', 'Investors', 'Partnerships'], 2, false)),
            'holding_back_growth_reason' => $this->faker->optional()->word,
            'other_comments' => $this->faker->optional()->sentence,
            'race_ethnicity' => $this->faker->optional()->randomElement(['Asian', 'Black', 'Hispanic', 'White', 'Other']),
            'gender' => $this->faker->optional()->randomElement(['Male', 'Female', 'Non-binary', 'Prefer not to say']),
            'team_identifiers' => $this->faker->optional()->randomElement(['Veteran', 'LGBTQ+', 'Immigrant', 'First-time founder']),
            'if_other_team_identifiers' => $this->faker->optional()->word,
        ];
    }
}
