<?php

namespace Database\Seeders;

use App\Models\OnboardingSurvey;
use Illuminate\Database\Seeder;

class OnboardingSurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 50 onboarding surveys
        OnboardingSurvey::factory()->count(5)->create();
    }
}
