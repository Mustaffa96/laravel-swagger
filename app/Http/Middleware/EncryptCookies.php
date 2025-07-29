<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * Cookie Encryption Middleware
 * 
 * Handles automatic encryption and decryption of cookies.
 * Provides security for sensitive cookie data.
 * 
 * @package App\Http\Middleware
 */
class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     * 
     * Lists cookies that should remain unencrypted for compatibility.
     * Useful for third-party integrations and debugging.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Add cookie names that should not be encrypted
        // Example: 'analytics_cookie', 'tracking_id'
    ];
}
