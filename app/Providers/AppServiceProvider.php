<?php

namespace App\Providers;

use App\Enums\Product\ProductType;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            ProductType::CLOTHES => ProductSize::class,
            ProductType::DEFAULT => Product::class,
        ]);
    }
}
