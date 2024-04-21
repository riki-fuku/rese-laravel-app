<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ratings')->insert([
            [
                'user_id' => 2,
                'shop_id' => 1,
                'rating' => 4,
                'comment' => '美味しかったです。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'shop_id' => 1,
                'rating' => 3,
                'comment' => '普通でした。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'shop_id' => 1,
                'rating' => 2,
                'comment' => 'まずかったです。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 5,
                'shop_id' => 1,
                'rating' => 1,
                'comment' => '最悪でした。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'shop_id' => 2,
                'rating' => 5,
                'comment' => '最高でした。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'shop_id' => 2,
                'rating' => 4,
                'comment' => '美味しかったです。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 4,
                'shop_id' => 2,
                'rating' => 3,
                'comment' => '普通でした。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'shop_id' => 3,
                'rating' => 1,
                'comment' => '最悪でした。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'shop_id' => 3,
                'rating' => 5,
                'comment' => '最高でした。',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'shop_id' => 4,
                'rating' => 2,
                'comment' => 'まずかったです。',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
