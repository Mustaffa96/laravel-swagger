<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Authentication Middleware
 * 
 * Handles user authentication for protected routes.
 * Redirects unauthenticated users appropriately based on request type.
 * 
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * 
     * For API requests, returns null to trigger a 401 response.
     * For web requests, redirects to login page.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        // For API requests, don't redirect - return 401 instead
        if ($request->expectsJson() || $request->is('api/*')) {
            return null;
        }

        // For web requests, redirect to login page
        return route('login');
    }
}
