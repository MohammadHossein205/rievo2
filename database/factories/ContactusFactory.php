<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contactus>
 */
class ContactusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location_image' => fake()->imageUrl(),
            'location_link' => fake()->url(),
            'face_to_face' => Faker::sentence(),
            'link_way' => Faker::paragraph(),
            'email' => fake()->safeEmail(),
            'telegram' => fake()->word,
            'instagram' => fake()->word,
            'whatsapp' => fake()->word,
            'eitaa' => fake()->word,
            'rubika' => fake()->word,
        ];
    }
}
