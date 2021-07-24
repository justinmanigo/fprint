<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at'=> now(),
            'password' => bcrypt('admin123'),
            'idNumber' => 1234562,
            'type' => "admin",
            'contact' => "12345678910",
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at'=> now(),
            'password' => bcrypt('user123'),
            'type' => "user",
            'idNumber' => 12345621,
            'contact' => "12345678910",
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}
