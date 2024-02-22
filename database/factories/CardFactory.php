<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 31),
            'card_number' => fake()->creditCardNumber(),
            'shaba_number' => 'IR' . fake()->shuffleString('123456789012345678901234'),
            'cvv2' => fake()->numberBetween(1000, 9999),
        ];
    }
}
