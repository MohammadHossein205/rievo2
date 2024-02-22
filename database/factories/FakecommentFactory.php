<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fakecomment>
 */
class FakecommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'namefamily' => Faker::firstName() . ' ' . Faker::lastName(),
            'image' => fake()->imageUrl(),
            'body' => Faker::paragraph(),
            'status' => rand(0, 1),
        ];
    }
}
