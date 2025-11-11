<?php

namespace Database\Factories;

use App\Models\Lot;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovementItem>
 */
class MovementItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stock_movement_id' => StockMovement::factory(),
            'product_id' => Product::factory(),
            'lot_id' => Lot::factory(),
            'supplier_id' => Supplier::factory(),
            'quantity' => fake()->numberBetween(1, 50),
            'price' => fake()->randomFloat(2, 2, 100)
        ];
    }
}
