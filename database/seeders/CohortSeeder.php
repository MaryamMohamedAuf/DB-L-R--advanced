<?php

namespace Database\Seeders;

use App\Models\Cohort;
use Illuminate\Database\Seeder;


class CohortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 cohorts
        Cohort::factory()->count(1)->create();
    }
}
