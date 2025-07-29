<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
| These routes are primarily for serving the Swagger documentation
| interface and any web-based administration tools.
|
*/

/*
|--------------------------------------------------------------------------
| Documentation Routes
|--------------------------------------------------------------------------
|
| Routes for accessing API documentation and related resources.
| The Swagger UI will be available at /api/documentation
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel Swagger CRUD API',
        'version' => '1.0.0',
        'documentation' => url('/api/documentation'),
        'api_info' => url('/api/info'),
        'health_check' => url('/api/health')
    ]);
});

/*
|--------------------------------------------------------------------------
| Health Check Route (Web)
|--------------------------------------------------------------------------
|
| Simple web-based health check for monitoring tools that prefer
| web routes over API routes.
|
*/
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString(),
        'database' => 'connected', // Could add actual DB check here
        'storage' => 'accessible'   // Could add actual storage check here
    ]);
});
