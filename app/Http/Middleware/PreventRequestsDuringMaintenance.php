<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

/**
 * Maintenance Mode Middleware
 * 
 * Handles requests during application maintenance mode.
 * Allows certain URIs to bypass maintenance restrictions.
 * 
 * @package App\Http\Middleware
 */
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     * 
     * Lists routes that should remain accessible during maintenance.
     * Useful for health checks and administrative access.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Health check endpoints should remain accessible
        '/api/health',
        
        // Documentation might be useful during maintenance
        '/api/documentation',
        
        // Admin routes (if implemented)
        // '/admin/*',
    ];
}
