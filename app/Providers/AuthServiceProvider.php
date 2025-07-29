<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * Authentication Service Provider
 * 
 * Registers authentication and authorization services.
 * Defines policies and gates for access control.
 * 
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     * 
     * Maps Eloquent models to their corresponding policy classes.
     * Enables automatic policy resolution for authorization.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Example: Document::class => DocumentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     * 
     * Defines custom gates and policies for fine-grained access control.
     * Can be extended to include API-specific authorization logic.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define custom gates for document operations
        Gate::define('upload-documents', function ($user = null) {
            // For now, allow all users to upload documents
            // This can be customized based on user roles or permissions
            return true;
        });

        Gate::define('download-documents', function ($user = null) {
            // For now, allow all users to download documents
            // This can be customized based on user roles or permissions
            return true;
        });

        Gate::define('delete-documents', function ($user = null) {
            // For now, allow all users to delete documents
            // This can be customized based on user roles or permissions
            return true;
        });

        // Example of more restrictive gate
        Gate::define('admin-only', function ($user = null) {
            // This would require user authentication and role checking
            // return $user && $user->hasRole('admin');
            return false; // Disabled for API-only application
        });
    }
}
