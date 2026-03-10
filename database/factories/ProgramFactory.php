<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'tax_amount' => $this->faker->randomFloat(2, 10, 200),
        ];
    }
}