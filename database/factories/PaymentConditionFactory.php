<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentCondition>
 */
class PaymentConditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_text' => Faker::sentence(),
            'body_text' => Faker::paragraph(),
            'image' => fake()->imageUrl(),
        ];
    }
}
