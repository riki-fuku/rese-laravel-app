<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_users')->insert([
            [
                'name' => 'agent1',
                'shop_id' => 1,
                'email' => 'agent1@aa.aa',
                'password' => bcrypt('hogehoge'),
                'invalid_flag' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'agent2',
                'shop_id' => 2,
                'email' => 'agent2@aa.aa',
                'password' => bcrypt('hogehoge'),
                'invalid_flag' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'agent3',
                'shop_id' => NULL,
                'email' => 'agent3@aa.aa',
                'password' => bcrypt('hogehoge'),
                'invalid_flag' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'agent4',
                'shop_id' => 4,
                'email' => 'agent4@aa.aa',
                'password' => bcrypt('hogehoge'),
                'invalid_flag' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'agent5',
                'shop_id' => 5,
                'email' => 'agent5@aa.aa',
                'password' => bcrypt('hogehoge'),
                'invalid_flag' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
