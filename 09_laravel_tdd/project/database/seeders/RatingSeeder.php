<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ratings')->insert([
            'rating' => 5,
            'user_id' => 1,
            'game_id' => 1,
        ]);

        DB::table('ratings')->insert([
            'rating' => 4,
            'user_id' => 2,
            'game_id' => 1,
        ]);

        DB::table('ratings')->insert([
            'rating' => 5,
            'user_id' => 3,
            'game_id' => 1,
        ]);

        DB::table('ratings')->insert([
            'rating' => 3,
            'user_id' => 5,
            'game_id' => 1,
        ]);

        DB::table('ratings')->insert([
            'rating' => 5,
            'user_id' => 5,
            'game_id' => 1,
        ]);
    }
}
