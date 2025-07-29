<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

/**
 * Application Service Provider
 * 
 * Registers application services and performs bootstrapping.
 * Optimized for PostgreSQL and follows clean architecture principles.
 * 
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * This method is used to bind services into the service container.
     * Following dependency injection principles for loose coupling.
     */
    public function register(): void
    {
        // Register custom services here if needed
        // Example: $this->app->bind(Interface::class, Implementation::class);
    }

    /**
     * Bootstrap any application services.
     * 
     * This method is called after all other service providers have been registered.
     * Used for configuration and setup that depends on other services.
     */
    public function boot(): void
    {
        // Set default string length for database compatibility
        // Optimized for PostgreSQL but maintains MySQL compatibility
        Schema::defaultStringLength(191);
        
        // Force HTTPS in production for security
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
