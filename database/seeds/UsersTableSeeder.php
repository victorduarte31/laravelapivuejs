<?php

use App\User;
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
        User::create([
            'name'      => 'Victor Duarte',
            'email'     => 'victor.mendonca@unigranrio.br',
            'password'  => bcrypt('12345678')
        ]);
    }
}
