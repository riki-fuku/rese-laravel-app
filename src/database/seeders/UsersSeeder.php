<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'user1',
                'email' => 'user1@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('hogehoge'),
                'invalid_flag' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
