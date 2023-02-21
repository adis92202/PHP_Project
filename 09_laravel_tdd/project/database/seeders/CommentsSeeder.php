<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            'text' => 'Czasochłonna ta gra',
            'user_id' => 1,
            'game_id' => 1,
        ]);
        DB::table('comments')->insert([
            'text' => 'Brajanek kocha',
            'user_id' => 2,
            'game_id' => 1,
        ]);
        DB::table('comments')->insert([
            'text' => 'Moja ulubiona',
            'user_id' => 5,
            'game_id' => 2,
        ]);
    }
}
