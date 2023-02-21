<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('auctions')->insert([
            'title' => 'Monopoly',
            'state' => 'New',
            'price' => '30',
            'description' => 'We argue too much. Buy it!',
            'email' => 'anna@banana.com',
            'phone' => '890890890',
            'user_id' => 6,
            'accepted' => true
        ]);
        DB::table('auctions')->insert([
            'title' => 'Cluedo',
            'state' => 'Good',
            'price' => '18',
            'description' => 'Old but working kind of',
            'email' => 'adam@gmail.com',
            'phone' => '123456789',
            'user_id' => 5,
            'accepted' => false
        ]);

        DB::table('auctions')->insert([
            'title' => 'Everdell',
            'state' => 'New',
            'price' => '25',
            'description' => 'Christmas gift',
            'email' => 'john.doe@gmail.com',
            'phone' => '666000666',
            'user_id' => 1,
            'accepted' => true
        ]);

        DB::table('auctions')->insert([
            'title' => 'Robinson Crusoe',
            'state' => 'Very good',
            'price' => '30',
            'description' => 'Special Edition! Only for true fans of survival.',
            'email' => 'john.doe@gmail.com',
            'phone' => '666000666',
            'user_id' => 1,
            'accepted' => true
        ]);
    }
}
