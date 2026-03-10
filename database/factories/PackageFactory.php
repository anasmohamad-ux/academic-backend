<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => 'Package ' . $this->faker->bothify('???###'),
            'hash' => md5($this->faker->unique()->sentence()),
        ];
    }
}