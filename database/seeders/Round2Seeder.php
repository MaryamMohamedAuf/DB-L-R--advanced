<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Round2;

class Round2Seeder extends Seeder
{
    /**
     * Seed the Round2 table.
     *
     * @return void
     */
    public function run()
    {
        Round2::factory()->count(5)->create(); // Adjust the count as needed
    }
}
