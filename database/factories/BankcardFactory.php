<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bankcard>
 */
class BankcardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 20),
            'bankname' => fake()->company(),
            'image' => fake()->imageUrl(),
            'cardnumber' => 1234567891234567,
            'shabanumber' => 'IR' . 123456789123456789123456,
            'status' => rand(0, 1),
        ];
    }
}
