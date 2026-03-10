<?php
namespace Database\Factories;

use App\Models\Package;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'package_id' => Package::factory(),
            'program_id' => Program::factory(),
            'paid_price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}