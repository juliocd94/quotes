<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            User::insert(
                [
                    [
                        'name' => 'John Doe',
                        'email' => 'john.doe@example.com',
                        'email_verified_at' => now(),
                        'password' => bcrypt('12345678'),
                        'remember_token' => Str::random(10),
                        'banning' => false,
                        'admin' => false,
                    ],
                    [
                        'name' => 'Admin User',
                        'email' => 'admin@example.com',
                        'email_verified_at' => now(),
                        'password' => bcrypt('12345678'),
                        'remember_token' => Str::random(10),
                        'banning' => false,
                        'admin' => true,
                    ],
                ]
            );
    }
}
