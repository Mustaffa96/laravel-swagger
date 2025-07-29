<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Document Controller
 * 
 * Handles CRUD operations for documents with file upload/download capabilities.
 * Implements clean architecture principles with proper separation of concerns.
 * All methods are documented with Swagger/OpenAPI annotations.
 * 
 * @package App\Http\Controllers
 */
class DocumentController extends Controller
{
    /**
     * Display a listing of documents.
     * 
     * Retrieves paginated list of documents with optional filtering.
     * Optimized for performance with selective field loading.
     *
     * @OA\Get(
     *     path="/api/documents",
     *     summary="Get list of documents",
     *     description="Retrieve a paginated list of documents with optional filtering by category and status",
     *     operationId="getDocuments",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1, default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", minimum=1, maximum=100, default=15)
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by document category",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by document status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"active", "inactive", "processing"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Document")),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        // Validate query parameters for security and data integrity
        $validator = Validator::make($request->all(), [
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
            'category' => 'string|max:50',
            'status' => 'in:active,inactive,processing',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid parameters',
                'details' => $validator->errors()
            ], 400);
        }

        // Build query with performance optimizations
        $query = Document::select([
            'id', 'title', 'description', 'file_name', 
            'file_size', 'mime_type', 'category', 'status', 
            'uploaded_by', 'created_at', 'updated_at'
        ]);

        // Apply filters if provided
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Order by creation date for consistent results
        $query->orderBy('created_at', 'desc');

        // Paginate results with configurable per_page
        $perPage = $request->get('per_page', 15);
        $documents = $query->paginate($perPage);

        return response()->json($documents);
    }

    /**
     * Store a newly created document with file upload.
     * 
     * Creates a new document record and handles file upload securely.
     * Implements proper validation and error handling.
     *
     * @OA\Post(
     *     path="/api/documents",
     *     summary="Create a new document",
     *     description="Upload a new document with metadata",
     *     operationId="storeDocument",
     *     tags={"Documents"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string", maxLength=255, description="Document title"),
     *                 @OA\Property(property="description", type="string", description="Document description"),
     *                 @OA\Property(property="category", type="string", maxLength=50, description="Document category"),
     *                 @OA\Property(property="uploaded_by", type="string", description="Uploader identifier"),
     *                 @OA\Property(property="file", type="string", format="binary", description="File to upload"),
     *                 required={"title", "file"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Document created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="document", ref="#/components/schemas/Document")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        // Comprehensive validation for security and data integrity
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:50',
            'uploaded_by' => 'nullable|string|max:255',
            'file' => 'required|file|max:10240', // 10MB max file size
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 400);
        }

        try {
            $file = $request->file('file');
            
            // Generate secure file path and name
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $secureFileName = Str::uuid() . '.' . $fileExtension;
            $filePath = 'documents/' . date('Y/m/d') . '/' . $secureFileName;
            
            // Store file securely
            $storedPath = $file->storeAs('documents/' . date('Y/m/d'), $secureFileName, 'local');
            
            if (!$storedPath) {
                return response()->json([
                    'error' => 'File upload failed'
                ], 500);
            }

            // Create document record with all metadata
            $document = Document::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_name' => $fileName,
                'file_path' => $storedPath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'category' => $request->get('category', 'general'),
                'status' => 'active',
                'uploaded_by' => $request->uploaded_by,
            ]);

            return response()->json([
                'message' => 'Document uploaded successfully',
                'document' => $document
            ], 201);

        } catch (\Exception $e) {
            // Clean up uploaded file if database operation fails
            if (isset($storedPath) && Storage::exists($storedPath)) {
                Storage::delete($storedPath);
            }

            return response()->json([
                'error' => 'Failed to create document',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified document.
     * 
     * Retrieves a single document by ID with all metadata.
     *
     * @OA\Get(
     *     path="/api/documents/{id}",
     *     summary="Get a specific document",
     *     description="Retrieve a document by its ID",
     *     operationId="getDocument",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Document ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Document")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function show(Document $document): JsonResponse
    {
        return response()->json($document);
    }

    /**
     * Update the specified document.
     * 
     * Updates document metadata. File replacement requires separate endpoint for security.
     *
     * @OA\Put(
     *     path="/api/documents/{id}",
     *     summary="Update a document",
     *     description="Update document metadata (not the file itself)",
     *     operationId="updateDocument",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Document ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", maxLength=255),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="category", type="string", maxLength=50),
     *             @OA\Property(property="status", type="string", enum={"active", "inactive", "processing"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Document updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="document", ref="#/components/schemas/Document")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function update(Request $request, Document $document): JsonResponse
    {
        // Validate update data
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:50',
            'status' => 'sometimes|in:active,inactive,processing',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 400);
        }

        try {
            // Update only provided fields
            $document->update($request->only([
                'title', 'description', 'category', 'status'
            ]));

            return response()->json([
                'message' => 'Document updated successfully',
                'document' => $document->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update document',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified document.
     * 
     * Soft deletes the document record and optionally removes the file.
     *
     * @OA\Delete(
     *     path="/api/documents/{id}",
     *     summary="Delete a document",
     *     description="Soft delete a document and optionally remove the file",
     *     operationId="deleteDocument",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Document ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="remove_file",
     *         in="query",
     *         description="Whether to permanently remove the file",
     *         required=false,
     *         @OA\Schema(type="boolean", default=false)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Document deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy(Request $request, Document $document): JsonResponse
    {
        try {
            $removeFile = $request->boolean('remove_file', false);
            
            // Remove physical file if requested
            if ($removeFile && $document->file_path && Storage::exists($document->file_path)) {
                Storage::delete($document->file_path);
            }

            // Soft delete the document record
            $document->delete();

            return response()->json([
                'message' => 'Document deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete document',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download the specified document file.
     * 
     * Securely serves the document file for download with proper headers.
     *
     * @OA\Get(
     *     path="/api/documents/{id}/download",
     *     summary="Download a document file",
     *     description="Download the actual file associated with a document",
     *     operationId="downloadDocument",
     *     tags={"Documents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Document ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File download",
     *         @OA\MediaType(
     *             mediaType="application/octet-stream",
     *             @OA\Schema(type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document or file not found"
     *     )
     * )
     */
    public function download(Document $document): Response|JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Verify file exists
        if (!$document->fileExists()) {
            abort(404, 'File not found');
        }

        $filePath = $document->getFullFilePath();
        
        // Return file download response with proper headers
        return response()->download($filePath, $document->file_name, [
            'Content-Type' => $document->mime_type,
            'Content-Length' => $document->file_size,
        ]);
    }
}
