<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        $users = [
            [
                'name' => 'Admin',
                'email' => '',
                'password' => Hash::make('password'),
                'role'=>'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Support Agent',
                'email' => 'agent@itsupport.test',
                'password' => Hash::make('password123'),
                'role' => 'agent',
                'email_verified_at' => now(),

            ],
            [
                'name' => 'Regular User',
                'email' => 'user@itsupport.test',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]

        ];

        DB::table('users')->insert($users);
    }
}
