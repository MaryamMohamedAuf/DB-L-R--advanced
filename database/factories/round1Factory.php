<?php
namespace Database\Factories;
use App\Models\Round1;
use App\Models\Applicant;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\Factory;

class Round1Factory extends Factory
{
    protected $model = Round1::class;

    public function definition()
    {
        // Get the last cohort id
        $lastCohortId = Cohort::latest('id')->value('id');

        return [
            'applicant_id' => Applicant::factory()->create()->id,
            'cohort_id' => $lastCohortId,
            'company_website' => $this->faker->url,
            'company_zip_code' => $this->faker->postcode,
            'year_company_founded' => $this->faker->year,
            'number_of_founding_team_members' => $this->faker->numberBetween(1, 10),
            'current_product_stage' => $this->faker->randomElement([
                'Idea', 'Some Research and/or Business Planning', 'Prototype Designed',
                'Prototype Developed', 'Beta Testing', 'Live Customers'
            ]),
            'current_business_stage' => $this->faker->randomElement([
                'Idea', 'Startup', 'Growth', 'Established', 'Expansion', 'Declining', 'Exit'
            ]),
            'company_formed' => $this->faker->randomElement([
                'No', 'Yes (LLC)', 'Yes (B-Corp)', 'Yes (C-Corp)', 'Yes (S-Corp)', 'Yes (Nonprofit)', 'Other'
            ]),
            'one_sentence_description' => $this->faker->sentence,
            'company_team_location' => $this->faker->randomElement([
                'Hawaii Island', 'Kauai', 'Lanai', 'Maui', 'Molokai', 'Niihau', 'Oahu', 'Other'
            ]),
            'if_you_selected_other_please_specify' => $this->faker->optional()->sentence,
            'short_problem_description' => $this->faker->paragraph,
            'detailed_description' => $this->faker->paragraphs(3, true),
            'applied_to_accelerator' => $this->faker->randomElement([
                'No', 'Yes - I was accepted and received funding',
                'Yes - I was accepted but there was no funding',
                'Yes - I was accepted but decided to pass',
                'Yes - I was not accepted / did not receive funding',
                'I’m not sure'
            ]),
            'previous_accelerator_places' => $this->faker->optional()->company,
            'If_Yes_please_indicate_ALL_the_PREVIOUS_places' => $this->faker->optional()->sentence,
            'funding_received' => implode(',', $this->faker->randomElements(['Angel', 'VC', 'Grant', 'Friends and Family', 'None'], 2, false) ?? []),
            'amount_funding_raised' => $this->faker->randomElement(['0-50k', '50k-100k', '100k-500k', '500k-1M', '1M+']),
            'revenue_generated' => $this->faker->randomElement(['0-50k', '50k-100k', '100k-500k', '500k-1M', '1M+']),
            'covid_impact' => $this->faker->randomElement([
                'No, it has not impacted business.',
                'Yes, and business is still struggling.',
                'Yes, initially but now business is back to near pre-pandemic levels.',
                'Yes, initially but now business is better than ever.',
                'Yes, but business has pivoted.'
            ]),
            'reason_for_applying' => $this->faker->paragraph,
            'biggest_challenge' => $this->faker->paragraph,
            'how_did_you_hear_about_us' => implode(',', $this->faker->randomElements(['Social Media', 'Friend', 'Website', 'Email', 'Other'], 2, false) ?? []),
            'race_ethnicity' => implode(',', $this->faker->optional()->randomElements(['Asian', 'Black', 'Hispanic', 'White', 'Other'], 2, false) ?? []),
            'gender' => implode(',', $this->faker->optional()->randomElements(['Male', 'Female', 'Non-binary', 'Prefer not to say'], 1, false) ?? []),
            'additional_demographics' => $this->faker->optional()->sentence,
            'team_identifiers' => implode(',', $this->faker->optional()->randomElements(['Veteran', 'LGBTQ+', 'Immigrant', 'First-time founder'], 2, false) ?? []),
        ];
    }
}
