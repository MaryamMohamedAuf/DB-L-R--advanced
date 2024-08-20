<?php

namespace Database\Seeders;

use App\Models\FollowupSurvey;
use Illuminate\Database\Seeder;

class FollowupSurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 50 follow-up surveys
        FollowupSurvey::factory()->count(5)->create();
    }
}
