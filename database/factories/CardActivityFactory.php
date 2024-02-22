<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardActivity>
 */
class CardActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 60),
            'payment_type' => 'واریز',
            'price' => fake()->numberBetween(10000, 99999),
            'wage' => fake()->numberBetween(10000, 99999),
            'card_number' => fake()->creditCardNumber(),
            'res_number' => fake()->numberBetween(10000, 99999),
            'status' => fake()->boolean(),
        ];
    }
}
