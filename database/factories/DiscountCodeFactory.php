<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DiscountCode>
 */
class DiscountCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discount_code' => Str::upper(Str::random(10)),
            'price' => fake()->randomNumber(8),
            'count' => rand(1, 10),
            'end_time' => fake()->dateTimeThisYear(),
        ];
    }
}
