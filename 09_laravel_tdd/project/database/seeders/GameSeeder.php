<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //rename(public_path().'/images/monopoly.jpeg', 'storage/app/public/images/monopoly.jpeg');
        //rename(public_path().'/images/anachrony.jpg', 'storage/app/public/images/anachrony.jpg');
        //rename(public_path().'/images/cluedo.jpg', 'storage/app/public/images/cluedo.jpg');
        //rename(public_path().'/images/codenames.jpg', 'storage/app/public/images/codenames.jpg');
        //rename(public_path().'/images/patchwork.jpg', 'storage/app/public/images/patchwork.jpg');
        //rename(public_path().'/images/scythe.jpg', 'storage/app/public/images/scythe.jpg');
        DB::table('games')->insert([
            'image' => 'seeder_monopoly.jpeg',
            'title' => 'Monopoly',
            'category' => 'Economic',
            'description' => 'Players take the part of land owners, attempting to buy and then develop their land. Income is gained by other players visiting their properties and money is spent when they visit properties belonging to other players. When times get tough, players may have to mortgage their properties to raise cash for fines, taxes and other misfortunes.',
            'year' => 1935,
            'players' => '2-6',
            'time' => 120,
            "accepted" => true,
            'created_at' => '2020-06-06 10:24',
        ]);
        DB::table('games')->insert([
            'image' => 'seeder_cluedo.jpg',
            'title' => 'Cluedo',
            'category' => 'Murder/Mystery',
            'description' => "The classic detective game! In Clue, players move from room to room in a mansion to solve the mystery of: who done it, with what, and where? Players are dealt character, weapon, and location cards after the top card from each card type is secretly placed in the confidential file in the middle of the board. Players must move to a room and then make a suggestion against a character saying they did it in that room with a specific weapon. The player to the left must show one of any cards mentioned if in that player's hand. Through deductive reasoning each player must figure out which character, weapon, and location are in the secret file. To do this, each player must uncover what cards are in other players hands by making more and more suggestions. Once a player knows what cards the other players are holding, they will know what cards are in the secret file, and then make an accusation. If correct, the player wins, but if incorrect, the player must return the cards to the file without revealing them and may no longer make suggestions or accusations. A great game for those who enjoy reasoning and thinking things out.",
            'year' => 1949,
            'players' => '2-6',
            'time' => 45,
            "accepted" => true,
            'created_at' => '2021-06-06 10:24',
        ]);
        DB::table('games')->insert([
            'image' => 'seeder_patchwork.jpg',
            'title' => 'Patchwork',
            'category' => 'Strategy',
            'description' => "In Patchwork, two players compete to build the most aesthetic (and high-scoring) patchwork quilt on a personal 9x9 game board. To start play, lay out all of the patches at random in a circle and place a marker directly clockwise of the 2-1 patch. Each player takes five buttons — the currency/points in the game — and someone is chosen as the start player.",
            'year' => 2014,
            'players' => '2-2',
            'time' => 25,
            "accepted" => true,
            'created_at' => '2022-06-06 10:24',
        ]);
        DB::table('games')->insert([
            'image' => 'seeder_codenames.jpg',
            'title' => 'Codenames',
            'category' => 'Party',
            'description' => "Codenames is an easy party game to solve puzzles.
The game is divided into red and blue, each side has a team leader, the team leader's goal is to lead their team to the final victory.
At the beginning of the game, there will be 25 cards on the table with different words. Each card has a corresponding position, representing different colors.
Only the team leader can see the color of the card. The team leader should prompt according to the words, let his team members find out the cards of their corresponding colors, and find out all the cards of their own colors to win.",
            'year' => 2015,
            'players' => '4-8',
            'time' => 45,
            "accepted" => true,
            'created_at' => '2022-08-06 12:24',
        ]);
        DB::table('games')->insert([
            'image' => 'seeder_anachrony.jpg',
            'title' => 'Anachrony',
            'category' => 'Strategy',
            'description' => "Anachrony features a unique two-tiered worker placement system. To travel to the Capital or venture out to the devastated areas for resources, players need not only various specialists (Engineers, Scientists, Administrators, and Geniuses) but also Exosuits to protect and enhance them — and both are in short supply.",
            'year' => 2017,
            'players' => '1-4',
            'time' => 120,
            "accepted" => true,
            'created_at' => '2023-01-01 00:00',
        ]);
        DB::table('games')->insert([
            'image' => 'seeder_scythe.jpg',
            'title' => 'Scythe',
            'category' => 'Economic',
            'description' => "It is a time of unrest in 1920s Europa. The ashes from the first great war still darken the snow. The capitalistic city-state known simply as “The Factory”, which fueled the war with heavily armored mechs, has closed its doors, drawing the attention of several nearby countries.
Scythe is an engine-building game set in an alternate-history 1920s period. It is a time of farming and war, broken hearts and rusted gears, innovation and valor. In Scythe, each player represents a character from one of five factions of Eastern Europe who are attempting to earn their fortune and claim their faction's stake in the land around the mysterious Factory. Players conquer territory, enlist new recruits, reap resources, gain villagers, build structures, and activate monstrous mechs.",
            'year' => 2016,
            'players' => '1-5',
            'time' => 90,
            'created_at' => '2022-12-24 17:00',
        ]);
    }
}
