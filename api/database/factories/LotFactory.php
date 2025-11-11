<?php

namespace Database\Factories;

use App\Models\DepositLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lot>
 */
class LotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(3),
            'expiration_date' => fake()->dateTimeBetween('now', '+1 year'),
            'deposit_location_id' => DepositLocation::factory()
        ];
    }
}
