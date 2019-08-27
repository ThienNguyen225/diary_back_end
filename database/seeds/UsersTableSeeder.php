<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'vampire',
            'email' => 'admin@gmail.com',
            'address' => 'Ha Noi',
            'age' => 26,
            'password' => bcrypt('admin123')
        ]);

        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'address' => $faker->address,
                'image' => $faker->imageUrl(1280, 720, null, true, null, false),
                'age' => $faker->numberBetween(1, 100),
                'password' => bcrypt('123456')
            ]);
        }
    }
}
