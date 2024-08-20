<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Round1;

class Round1Seeder extends Seeder
{
    /**
     * Seed the database with round1 records.
     *
     * @return void
     */
    public function run()
    {
        // Seed the database with 10 round1 records
        Round1::factory()->count(10)->create();
        // ->each(function ($round1) {
        //     $round1->update([
        //         'how_did_you_hear_about_us' => implode(',', $round1->how_did_you_hear_about_us ?? []),
        //         'funding_received' => implode(',', $round1->funding_received ?? []),
        //         'race_ethnicity' => implode(',', $round1->race_ethnicity ?? []),
        //         'gender' => implode(',', $round1->gender ?? []),
        //         'team_identifiers' => implode(',', $round1->team_identifiers ?? []),
        //     ]);
        // });
    }
    
}
