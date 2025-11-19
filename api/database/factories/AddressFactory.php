<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'logradouro' => fake()->streetName(),
            'number' => fake()->buildingNumber(),
            'complemento' => fake()->secondaryAddress() ,
            'city_id' => City::factory(),
            'bairro' => fake()->citySuffix(),
            'cep' => fake()->numerify('#######')
        ];
    }
}
