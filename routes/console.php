<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

/**
 * Inspirational quote command
 * 
 * Provides motivational quotes for developers.
 * Useful for team morale and development inspiration.
 */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Custom Swagger generation command
 * 
 * Regenerates Swagger documentation with custom options.
 * Useful for automated documentation updates.
 */
Artisan::command('docs:generate', function () {
    $this->info('Generating Swagger documentation...');
    
    // Generate L5-Swagger documentation
    $this->call('l5-swagger:generate');
    
    $this->info('Swagger documentation generated successfully!');
    $this->line('Access it at: ' . config('app.url') . '/api/documentation');
})->purpose('Generate comprehensive API documentation');

/**
 * Database setup command
 * 
 * Sets up the database with migrations and sample data.
 * Useful for quick development environment setup.
 */
Artisan::command('setup:database', function () {
    $this->info('Setting up database...');
    
    // Run migrations
    $this->call('migrate');
    
    // Create storage link if it doesn't exist
    if (!file_exists(public_path('storage'))) {
        $this->call('storage:link');
    }
    
    $this->info('Database setup completed successfully!');
})->purpose('Setup database with migrations and storage');

/**
 * Project cleanup command
 * 
 * Cleans up temporary files and optimizes the application.
 * Useful for maintenance and performance optimization.
 */
Artisan::command('cleanup:project', function () {
    $this->info('Cleaning up project...');
    
    // Clear various caches
    $this->call('cache:clear');
    $this->call('config:clear');
    $this->call('route:clear');
    $this->call('view:clear');
    
    // Clear compiled files
    $this->call('clear-compiled');
    
    // Optimize autoloader
    $this->call('optimize');
    
    $this->info('Project cleanup completed successfully!');
})->purpose('Clean up caches and optimize the application');
