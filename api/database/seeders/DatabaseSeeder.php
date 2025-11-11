<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\DepositLocation;
use App\Models\Lot;
use App\Models\MeasurementUnit;
use App\Models\MovementItem;
use App\Models\Product;
use App\Models\Region;
use App\Models\State;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Cria um user admin
        User::factory()->create([
            'name' => 'Vitor Martins',
            'email' => 'vitor@gmail.com',
            'cpf' => '70223402184',
            'role' => 'admin',
            'password' => Hash::make('vitor123'),
        ]);

        //Chama a factory pra criar  users
        User::factory(5)->create([
            'role' => 'funcionario',
        ]);

        // Categorias, marcas e unidades
        $categories = Category::factory(5)->create();
        $brands = Brand::factory(5)->create();
        $units = MeasurementUnit::factory(3)->create();

        // Endereços e fornecedores
        $regions = Region::factory(5)->create();
        $states = State::factory(10)->create([
            'region' => $regions->random()->id
        ]);
        $cities = City::factory(10)->create([
            'uf' => fn() => $states->random()->uf,
        ]);
        $addresses = Address::factory(5)->create([
            'city_id' => $cities->random()->id
        ]);
        $suppliers = Supplier::factory(5)->create([
            'address_id' => $addresses->random()->id
        ]);

        //Locais de desposito e lotes
        $locations = DepositLocation::factory(3)->create();
        $lots = Lot::factory(10)->create([
            'deposit_location_id' => $locations->random()->id,
        ]);

        //Produtos
        $products = Product::factory(10)->create([
            'category_id' => $categories->random()->id,
            'brand_id' => $brands->random()->id,
            'unit_id' => $units->random()->id,
        ]);

        // Movimentações de estoque e itens
        StockMovement::factory(5)
            ->create()
            ->each(function ($movement) use ($products, $lots, $suppliers) {
                MovementItem::factory(3)->create([
                    'stock_movement_id' => $movement->id,
                    'product_id' => $products->random()->id,
                    'lot_id' => $lots->random()->id,
                    'supplier_id' => $suppliers->random()->id,
                ]);
            });
    }
}
