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
        $this->call([
        RegionsSeeder::class,
        StatesSeeder::class,
        MeasurementUnitsSeder::class,
        CitiesSeder::class,
        AddressesSeeder::class,
        UsersSeeder::class
    ]);
    }
}
