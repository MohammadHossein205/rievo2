<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 10),
            'body' => Faker::paragraph(),
            'commentable_id' => rand(1, 20),
            'commentable_type' => 'App\Models\Dam',
            'rate' => rand(1, 5),
            'status' => rand(0, 1),
        ];
    }
}
