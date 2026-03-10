<?php
namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        Program::insert([
            ['name' => 'College Program', 'tax_amount' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Employee Program', 'tax_amount' => 75, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Complete Transformation', 'tax_amount' => 100, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}