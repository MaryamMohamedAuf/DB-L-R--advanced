<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cohort;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cohort>
 */
class cohortFactory extends Factory
{
    protected $model = Cohort::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(2), //not more than 2 digits, only until 99 max
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
