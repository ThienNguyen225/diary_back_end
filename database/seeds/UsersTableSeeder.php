<?php

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
        $user = new \App\User();
        $user->name = 'vampire';
        $user->email = 'admin@gmail.com';
        $user->password = \Illuminate\Support\Facades\Hash::make('admin123');
        $user->save();
    }
}
