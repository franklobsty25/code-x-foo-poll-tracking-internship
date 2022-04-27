<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create default candidate

        Candidate::create([
            'position' => 'Presidential',
            'ballot_placement' => 1,
            'first_name' => 'Frank',
            'last_name' => 'Kodie',
        ]);
    }
}
