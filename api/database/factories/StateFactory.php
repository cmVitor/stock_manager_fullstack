<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigouf' => fake()->numerify('####'),
            'name' => fake()->name(),
            'uf' => strtoupper(fake()->randomLetter() . fake()->randomLetter()),
            'region' => Region::factory()
        ];
    }
}
