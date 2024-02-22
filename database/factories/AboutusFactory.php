<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aboutus>
 */
class AboutusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'big_title' => Faker::sentence(),
            'small_title' => Faker::sentence(),
            'big_text' => Faker::paragraph(),
            'about_text' => Faker::paragraph(),
            'image' => fake()->imageUrl(590, 720),
        ];
    }
}
