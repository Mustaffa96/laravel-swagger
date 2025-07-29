<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller Class
 * 
 * Provides common functionality for all controllers.
 * Includes Swagger/OpenAPI documentation configuration.
 * 
 * @OA\Info(
 *     title="Laravel Swagger CRUD API",
 *     version="1.0.0",
 *     description="A comprehensive CRUD API with file upload/download capabilities using Laravel and PostgreSQL. Built following SOLID principles and clean architecture.",
 *     @OA\Contact(
 *         email="admin@example.com",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter token in format (Bearer <token>)"
 * )
 * 
 * @OA\Schema(
 *     schema="Document",
 *     type="object",
 *     title="Document",
 *     description="Document model with file upload capabilities",
 *     @OA\Property(property="id", type="integer", format="int64", description="Unique identifier"),
 *     @OA\Property(property="title", type="string", maxLength=255, description="Document title"),
 *     @OA\Property(property="description", type="string", description="Document description"),
 *     @OA\Property(property="file_name", type="string", description="Original file name"),
 *     @OA\Property(property="file_size", type="integer", description="File size in bytes"),
 *     @OA\Property(property="file_size_human", type="string", description="Human readable file size"),
 *     @OA\Property(property="mime_type", type="string", description="File MIME type"),
 *     @OA\Property(property="category", type="string", description="Document category"),
 *     @OA\Property(property="status", type="string", enum={"active", "inactive", "processing"}, description="Document status"),
 *     @OA\Property(property="uploaded_by", type="string", description="Uploader identifier"),
 *     @OA\Property(property="download_url", type="string", format="uri", description="Download URL"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp"),
 *     required={"id", "title", "file_name", "file_size", "mime_type", "status"}
 * )
 * 
 * @OA\Schema(
 *     schema="Error",
 *     type="object",
 *     title="Error Response",
 *     description="Standard error response format",
 *     @OA\Property(property="error", type="string", description="Error message"),
 *     @OA\Property(property="details", type="object", description="Additional error details"),
 *     @OA\Property(property="message", type="string", description="Detailed error message")
 * )
 * 
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
