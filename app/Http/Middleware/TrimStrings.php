<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * String Trimming Middleware
 * 
 * Automatically trims whitespace from request input strings.
 * Improves data consistency and prevents common input issues.
 * 
 * @package App\Http\Middleware
 */
class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     * 
     * Lists input fields that should preserve whitespace.
     * Useful for passwords and formatted text content.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
        
        // Preserve whitespace in document descriptions
        // as they might contain formatted content
        'description',
    ];
}
