<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ezy.com',
            'password' => Hash::make('password'),
        ])->assignRole('admin');

        User::create([
            'name' => 'Teacher One',
            'email' => 'teacher@ezy.com',
            'password' => Hash::make('password'),
        ])->assignRole('teacher');

        User::create([
            'name' => 'Student One',
            'email' => 'student@ezy.com',
            'password' => Hash::make('password'),
        ])->assignRole('student');
    }
}