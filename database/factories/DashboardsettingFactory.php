<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dashboardsetting>
 */
class DashboardsettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->unique()->numberBetween(1, 20),
            'email_notification' => fake()->boolean(),
            'new_order_accept_sms' => fake()->boolean(),
            'new_order_cancel_sms' => fake()->boolean(),
        ];
    }
}
