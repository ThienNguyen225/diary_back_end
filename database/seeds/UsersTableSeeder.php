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
            'address' => 'Hai Duong',
            'age' => 26,
            'password' => bcrypt('admin123')
        ]);

        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user = new \App\User();
            $phone = '09' . mt_rand(1000000, 9999999);
            $data = [
                'name' => $faker->name,
                'email' => $faker->email,
                'address' => $faker->address,
                'image' => $faker->imageUrl(1280, 720, null, true, null, false),
                'age' => $faker->numberBetween(1, 100),
                'phone' => $phone,
                'password' => bcrypt('123456')
            ];
            $user->create($data);
        }
    }
}
