<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

/**
 * Proxy Trust Middleware
 * 
 * Configures trusted proxies for proper request handling.
 * Essential for applications behind load balancers or CDNs.
 * 
 * @package App\Http\Middleware
 */
class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     * 
     * Lists IP addresses or CIDR blocks of trusted proxies.
     * Set to '*' to trust all proxies (use with caution).
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     * 
     * Configures which headers to trust for proxy information.
     * Optimized for common proxy and load balancer configurations.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
