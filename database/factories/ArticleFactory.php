<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => Faker::jobTitle(),
            'slug' => fake()->slug(),
            'image' => fake()->imageUrl(400, 400),
            'body' => Faker::paragraph(),
            'time' => rand(5, 100),
            'type' => Faker::sentence(),
        ];
    }
}
