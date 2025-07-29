<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
| All routes follow RESTful conventions and are properly documented
| with Swagger annotations for comprehensive API documentation.
|
*/

/*
|--------------------------------------------------------------------------
| Document Management Routes
|--------------------------------------------------------------------------
|
| These routes handle CRUD operations for documents including file
| upload and download functionality. All routes are optimized for
| performance and follow clean architecture principles.
|
*/

// Document CRUD routes with resource controller
Route::apiResource('documents', DocumentController::class);

// Additional document-specific routes for file operations
Route::get('documents/{document}/download', [DocumentController::class, 'download'])
    ->name('documents.download');

/*
|--------------------------------------------------------------------------
| Health Check Route
|--------------------------------------------------------------------------
|
| Simple health check endpoint to verify API availability.
| Useful for monitoring and load balancer health checks.
|
*/
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
});

/*
|--------------------------------------------------------------------------
| API Information Route
|--------------------------------------------------------------------------
|
| Provides basic API information and available endpoints.
| Helpful for API discovery and documentation.
|
*/
Route::get('/info', function () {
    return response()->json([
        'name' => 'Laravel Swagger CRUD API',
        'version' => '1.0.0',
        'description' => 'CRUD API with file upload/download capabilities',
        'documentation' => url('/api/documentation'),
        'endpoints' => [
            'documents' => [
                'GET /api/documents' => 'List all documents',
                'POST /api/documents' => 'Create new document with file upload',
                'GET /api/documents/{id}' => 'Get specific document',
                'PUT /api/documents/{id}' => 'Update document metadata',
                'DELETE /api/documents/{id}' => 'Delete document',
                'GET /api/documents/{id}/download' => 'Download document file'
            ]
        ]
    ]);
});
