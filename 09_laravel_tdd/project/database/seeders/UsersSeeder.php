<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'email' => 'john.doe@gmail.com',
            'password' => bcrypt('secret'),
            'username' => 'jdoe',
            'city' => 'Mediolan',
            'age' => 17,
            'socialized' => false,
            'email_verified_at' => '2020.07.08',
        ]);
        DB::table('users')->insert([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminadmin'),
            'username' => 'admin',
            'city' => 'Krakow',
            'age' => 25,
            'socialized' => false,
            'admin'=> true,
            'email_verified_at' => '2001.01.01',
        ]);
        DB::table('users')->insert([
            'email' => 'pawel@gmail.com',
            'password' => bcrypt('linuxcool'),
            'username' => 'PawLi',
            'city' => 'Radom',
            'age' => 42,
            'socialized' => true,
        ]);
        DB::table('users')->insert([
            'email' => 'agata@gmail.com',
            'password' => bcrypt('agatkaszmatka'),
            'username' => 'Aga123',
            'city' => 'Kraków',
            'age' => 22,
            'socialized' => true,
            'email_verified_at' => '2022.01.01'
        ]);
        DB::table('users')->insert([
            'email' => 'adam@gmail.com',
            'password' => bcrypt('skarpetki'),
            'username' => 'AdamP',
            'city' => 'Częstochowa',
            'age' => 21,
            'socialized' => false,
            'email_verified_at' => '2022.01.01'
        ]);

        DB::table('users')->insert([
            'email' => 'anna@banana.com',
            'password' => bcrypt('fun'),
            'username' => 'Banan',
            'city' => 'Berlin',
            'age' => 36,
            'socialized' => true,
            'email_verified_at' => '2023.01.06'
        ]);
    }
}
