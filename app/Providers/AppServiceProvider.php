<?php
namespace App\Providers;

use App\Contracts\PricingStrategyInterface;
use App\Services\PricingService;
use App\Services\PackageService;
use App\Services\EnrollmentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(PricingStrategyInterface::class, PricingService::class);
        $this->app->singleton(PackageService::class);
        $this->app->singleton(EnrollmentService::class);
    }

    public function boot(): void
    {
    }
}