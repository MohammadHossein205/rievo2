<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Questionanswer>
 */
class QuestionanswerFactory extends Factory
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
            'body' => Faker::paragraph(),
            'parent_id' => rand(1, 20),
            'questionanswerable_id' => rand(1, 20),
            'questionanswerable_type' => 'App\Models\Dam',
            'status' => rand(0, 1),
        ];
    }
}
