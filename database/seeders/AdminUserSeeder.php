<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Test',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'access_type' => 1,
                'status' => 1,
            ],
            [
                'first_name' => 'Staff',
                'last_name' => 'Test',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('12345678'),
                'access_type' => 2,
                'status' => 1,
            ],
        ];
        User::insert($users);
    }
}
