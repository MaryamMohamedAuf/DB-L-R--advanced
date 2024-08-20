<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Applicant;
use App\Models\Cohort;
use App\Models\Round1;
use App\Models\Round2;
use App\Models\Round3;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = \App\Models\Comment::class;

    public function definition()
    {
        $lastCohortId = Cohort::latest('id')->value('id');

        return [
            'user_id' => User::inRandomOrder()->first()->id, // Get a random existing User ID
            'applicant_id' => Applicant::inRandomOrder()->first()->id, // Get a random existing Applicant ID
            'cohort_id' => $lastCohortId,
            'round1_id' => Round1::inRandomOrder()->first()->id, // Get a random existing Round1 ID
            'round2_id' => Round2::inRandomOrder()->first()->id, // Get a random existing Round2 ID
            'round3_id' => Round3::inRandomOrder()->first()->id, // Get a random existing Round3 ID
            'feedback' => $this->faker->paragraph,
            'decision' => $this->faker->optional()->randomElement(['accepted', 'rejected']),
        ];
    }
}
