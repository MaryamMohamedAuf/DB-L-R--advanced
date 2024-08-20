<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Round3;

class Round3Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed with 10 Round3 records
        Round3::factory()->count(5)->create();
    }
}
