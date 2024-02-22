<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Connecteddevices>
 */
class ConnectedDevicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 30),
            'browser_name' => fake()->name(),
            'device' => fake()->name(),
            'ip' => fake()->ipv4(),
            'user_location' => fake()->streetName(),
            'status' => 0,
        ];
    }
}
