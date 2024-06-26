<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            ['id' => 1, 'name' => '東京都', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => '大阪府', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => '福岡県', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
