<?php

namespace Database\Seeders;

use App\Http\Controllers\RatingController;
use App\Models\Game;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(AuctionsSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(RatingSeeder::class);
    }
}
