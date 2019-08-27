<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class DiaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $faker = Factory::create();
            DB::table('diaries')->insert([
                'title' => $faker->title,
                'contents' => $faker->words(20, true),
                'id_user' => 1
            ]);
        }
    }
}
