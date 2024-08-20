<?php

namespace Database\Seeders;

use App\Models\OnboardingSurvey;
use App\Models\Round1;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

       // $this->call(CohortSeeder::class);
        $this->call(Seeder::class);
        $this->call(Round1Seeder::class);
        $this->call(Round2Seeder::class);
        $this->call(Round3Seeder::class);
        $this->call(ApplicantSeeder::class);
        $this->call(FollowupSurveySeeder::class);
        $this->call(OnboardingSurveySeeder::class);
        $this->call(SurveySeeder::class);
        $this->call(CommentSeeder::class);
    }
}
