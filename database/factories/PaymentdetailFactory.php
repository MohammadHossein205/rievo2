<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ybazli\Faker\Facades\Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paymentdetail>
 */
class PaymentdetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_id' => rand(1, 20),
            'paymentable_id' => rand(1, 20),
            'paymentable_type' => 'App\Models\Dam',
            'description' => Faker::paragraph(),
            'count' => rand(1, 100),
        ];
    }
}
