<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletText>
 */
class WalletTextFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_text' => Faker::sentence(),
            'title_description' => Faker::paragraph(),
            'about_wallet' => Faker::paragraph(),
        ];
    }
}
