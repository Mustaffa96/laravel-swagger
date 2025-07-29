<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * CSRF Token Verification Middleware
 * 
 * Protects against Cross-Site Request Forgery attacks.
 * Excludes API routes which use different authentication methods.
 * 
 * @package App\Http\Middleware
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * 
     * Lists routes that should bypass CSRF protection.
     * API routes typically use token-based authentication instead.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Exclude all API routes from CSRF verification
        // as they use token-based authentication
        'api/*',
        
        // Webhook endpoints (if implemented)
        // 'webhooks/*',
        
        // File upload endpoints might need CSRF exemption
        // depending on implementation
        // 'upload/*',
    ];
}
