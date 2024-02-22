<?php

namespace Database\Factories;

use App\Models\Dam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sell>
 */
class SellFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 40),
            'dam_id' => fake()->numberBetween(1, 60),
            'dam_type' => Dam::class,
            'status' => rand(0, 1),
        ];
    }
}
