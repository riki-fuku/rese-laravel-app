<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->insert([
            [
                'name' => 'admin1',
                'email' => 'admin1@mail.com',
                'password' => bcrypt('hogehoge'),
                'invalid_flag' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
