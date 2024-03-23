<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AreasSeeder::class);
        $this->call(GenresSeeder::class);
        $this->call(ShopsSeeder::class);
        $this->call(AdminUsersSeeder::class);
        $this->call(EmailTemplatesSeeder::class);
    }
}
