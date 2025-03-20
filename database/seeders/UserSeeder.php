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
        $users = [
            // Data Dummy
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@gmail.com',
                'whatsapp' => '08123456789',
                'role'     => 'superAdmin',
                'password' => Hash::make('lorem-ipsum')
            ],
            [
                'name'     => 'Admin',
                'email'    => 'admin@gmail.com',
                'whatsapp' => '08123456789',
                'role'     => 'admin',
                'password' => Hash::make('lorem-ipsum'),
            ],
            [
                'name'     => 'Teacher',
                'email'    => 'teacher@gmail.com',
                'whatsapp' => '08123456789',
                'role'     => 'user',
                'password' => Hash::make('lorem-ipsum'),
            ],
            [
                'name'     => 'Student',
                'email'    => 'student@gmail.com',
                'whatsapp' => '08123456789',
                'role'     => 'user',
                'password' => Hash::make('lorem-ipsum'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
