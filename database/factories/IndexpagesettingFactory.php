<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class IndexpagesettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'top_big_text' => Faker::sentence(),
            'top_small_text' => Faker::sentence(),
            'top_big_description' => Faker::sentence(),
            'estelam_text' => Faker::sentence(),
            'baner_one_image' => fake()->imageUrl(1300, 400),
            'baner_one_image_link' => fake()->url(),
            'baner_two_image' => fake()->imageUrl(1300, 400),
            'baner_two_image_link' => fake()->url(),
            'more_information_title' => Faker::sentence(),
            'more_information_text' => Faker::sentence(),
            'phone_text' => '021' . fake()->randomNumber(),
        ];
    }
}
