<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use function Ybazli\Faker\randomNumber;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'payment_type' => 'کارت',
            'resNumber' => fake()->numberBetween(1000000, 9999999),
            'discount' => rand(1, 100),
            'discount_price' => fake()->numberBetween(1000000, 9999999),
            'price' => fake()->numberBetween(1000000, 9999999),
            'status' => rand(0, 1),
            'buyorsell' => rand(0, 1),
        ];
    }
}
