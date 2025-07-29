<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

/**
 * Signature Validation Middleware
 * 
 * Validates signed URLs to ensure they haven't been tampered with.
 * Provides security for temporary download links and sensitive operations.
 * 
 * @package App\Http\Middleware
 */
class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     * 
     * Lists parameters that can be modified without invalidating the signature.
     * Useful for tracking parameters and optional query strings.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Allow tracking parameters without breaking signatures
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        
        // Allow debug parameters in development
        'debug',
        'preview',
    ];
}
