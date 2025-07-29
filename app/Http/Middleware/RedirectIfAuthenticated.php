<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirect Authenticated Users Middleware
 * 
 * Redirects already authenticated users away from guest-only routes.
 * Prevents authenticated users from accessing login/register pages.
 * 
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * 
     * Checks if user is authenticated and redirects appropriately.
     * For API requests, returns JSON response instead of redirect.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param string|null ...$guards
     * @return Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // For API requests, return JSON response
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'message' => 'Already authenticated',
                        'redirect' => RouteServiceProvider::HOME
                    ], 200);
                }

                // For web requests, redirect to home
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
