<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FactorDetail>
 */
class FactorDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'factor_id' => rand(1, 20),
            'factortable_id' => rand(1, 20),
            'count' => rand(1, 100),
        ];
    }
}
