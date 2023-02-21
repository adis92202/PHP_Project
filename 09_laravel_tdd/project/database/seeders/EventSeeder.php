<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'title' => 'Carcassonne lovers',
            'location' => 'Boardowa',
            'city' => 'Kraków',
            'description' => 'All ages welcome',
            'date' => '2023.01.19',
            'time' => '10:00',
            'size' => '50',
            'accepted' => true,
            'creator_id' => 1
        ]);
        DB::table('events')->insert([
            'title' => 'Anachrony learning',
            'location' => 'Hex',
            'city' => 'Kraków',
            'description' => "We'll learn to play the game, different strategies and then play in groups",
            'date' => '2023.01.30',
            'time' => '20:00',
            'size' => '20',
            'accepted' => true,
            'creator_id' => 1
        ]);
        DB::table('events')->insert([
            'title' => 'Monopoly for everyone',
            'location' => 'AGH Library',
            'city' => 'Kraków',
            'description' => "We'll be playing classic Monopoly with as much people as possible",
            'date' => '2023.01.19',
            'time' => '13:00',
            'size' => '200',
            'accepted' => true,
            'creator_id' => 1
        ]);
        DB::table('events')->insert([
            'title' => 'Scythe one game',
            'location' => 'Boradowa',
            'city' => 'Kraków',
            'description' => "I'm looking for 4 people to play my favorite game",
            'date' => '2023.01.21',
            'time' => '16:00',
            'size' => '4',
            'accepted' => true,
            'creator_id' => 2
        ]);
    }
}
