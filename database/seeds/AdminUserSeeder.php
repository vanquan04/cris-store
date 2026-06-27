<?php

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::updateOrCreate(
            ['username' => 'admin123'],
            [
                'name' => 'Administrator',
                'email' => 'admin@crisstore.com',
                'password' => Hash::make('admin123'),
                'isAdmin' => 1,
                'points' => '0'
            ]
        );
    }
}
