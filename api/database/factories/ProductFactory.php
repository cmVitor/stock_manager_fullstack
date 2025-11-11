<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\MeasurementUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'code' => strtoupper((fake()->unique()->bothify('PROD-###'))),
            'min_quantity' => fake()->numberBetween(1, 200),
            'unit_id' => MeasurementUnit::factory(),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'nutrition_facts' => json_encode([
                'portion' => '100g',
                'calories' => fake()->randomFloat(1, 50, 400),
                'protein' => fake()->randomFloat(1, 0, 30),
                'carbs' => fake()->randomFloat(1, 0, 50),
                'fat' => fake()->randomFloat(1, 0, 20),
            ]),
        ];
    }
}
