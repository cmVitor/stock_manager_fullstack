<?php

namespace App\Providers;

use App\Models\Supplier;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\{
    CategoryRepository,
    BrandRepository,
    UnitRepository,
    ProductRepository,
    RegionRepository,
    StateRepository,
    CityRepository,
    AddressRepository,
    SupplierRepository,
    DepositLocationRepository,
    LotRepository,
    StockMovementRepository,
    MovementItemRepository,
    UserRepository
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepository(new \App\Models\User());
        });
        $this->app->bind(BrandRepository::class, function ($app) {
            return new BrandRepository(new \App\Models\Brand());
        });
        $this->app->bind(CategoryRepository::class, function ($app) {
            return new CategoryRepository(new \App\Models\Category());
        });
        $this->app->bind(UnitRepository::class, function ($app) {
            return new UnitRepository(new \App\Models\MeasurementUnit());
        });
        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository(new \App\Models\Product());
        });
        $this->app->bind(RegionRepository::class, function ($app) {
            return new RegionRepository(new \App\Models\Region());
        });
        $this->app->bind(StateRepository::class, function ($app) {
            return new StateRepository(new \App\Models\State());
        });
        $this->app->bind(CityRepository::class, function ($app) {
            return new CityRepository(new \App\Models\City());
        });
        $this->app->bind(AddressRepository::class, function ($app) {
            return new AddressRepository(new \App\Models\Address());
        });
        $this->app->bind(SupplierRepository::class, function ($app) {
            return new SupplierRepository(new \App\Models\Supplier());
        });
        $this->app->bind(DepositLocationRepository::class, function ($app) {
            return new DepositLocationRepository(new \App\Models\DepositLocation());
        });
        $this->app->bind(LotRepository::class, function ($app) {
            return new LotRepository(new \App\Models\Lot());
        });
        $this->app->bind(StockMovementRepository::class, function ($app) {
            return new StockMovementRepository(new \App\Models\StockMovement());
        });
        $this->app->bind(MovementItemRepository::class, function ($app) {
            return new MovementItemRepository(new \App\Models\MovementItem());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
