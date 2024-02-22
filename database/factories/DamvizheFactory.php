<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Damvizhe>
 */
class DamvizheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => rand(1, 20),
            'group_company_id' => rand(1, 20),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'code' => Str::random(10),
            'price' => fake()->numberBetween(1000000, 9999999),
            'weight' => rand(1, 100),
            'color' => fake()->colorName(),
            'colorenglish' => fake()->colorName(),
            'ageYear' => rand(1300, 1500),
            'ageMonth' => fake()->month(),
            'gender' => rand(0, 1),
            'haveMilk' => rand(0, 1),
            'milk_amount' => rand(20, 50),
            'description' => fake()->paragraph(30),
            'disount_price' => fake()->numberBetween(100000, 999999),
            'disount_time' => fake()->date(),
        ];
    }
}
