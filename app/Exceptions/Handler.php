<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

/**
 * Exception Handler
 * 
 * Handles all application exceptions with proper error responses.
 * Provides consistent API error formatting and logging.
 * Follows clean architecture principles for error handling.
 * 
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * 
     * Configures custom exception handling for better API responses.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Custom logging logic can be added here
        });
    }

    /**
     * Render an exception into an HTTP response.
     * 
     * Provides consistent JSON error responses for API endpoints.
     * Handles different exception types with appropriate status codes.
     *
     * @param Request $request
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        // Handle API requests with JSON responses
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle API exceptions with consistent JSON responses.
     * 
     * Provides standardized error format for all API endpoints.
     * Includes proper status codes and error messages.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     */
    protected function handleApiException(Request $request, Throwable $e): JsonResponse
    {
        // Handle validation exceptions
        if ($e instanceof ValidationException) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'The given data was invalid.',
                'details' => $e->errors()
            ], 422);
        }

        // Handle not found exceptions
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'error' => 'Resource not found',
                'message' => 'The requested resource could not be found.'
            ], 404);
        }

        // Handle method not allowed exceptions
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => 'Method not allowed',
                'message' => 'The HTTP method is not allowed for this endpoint.'
            ], 405);
        }

        // Handle general exceptions
        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
        
        // Don't expose sensitive error details in production
        $message = app()->environment('production') 
            ? 'An error occurred while processing your request.'
            : $e->getMessage();

        return response()->json([
            'error' => 'Server error',
            'message' => $message,
            'code' => $statusCode
        ], $statusCode);
    }
}
