<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Documents Table Migration
 * 
 * Creates the documents table with optimized structure for PostgreSQL.
 * Includes proper indexing for performance and follows clean architecture principles.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the documents table with all necessary fields for file management.
     * Optimized for PostgreSQL with proper data types and constraints.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            // Primary key with auto-increment
            $table->id();
            
            // Document metadata fields
            $table->string('title')->index(); // Indexed for search performance
            $table->text('description')->nullable();
            
            // File-related fields
            $table->string('file_name');
            $table->string('file_path')->unique(); // Unique constraint for file integrity
            $table->bigInteger('file_size')->unsigned(); // File size in bytes
            $table->string('mime_type', 100); // MIME type for proper file handling
            
            // Categorization and status
            $table->string('category', 50)->default('general')->index(); // Indexed for filtering
            $table->enum('status', ['active', 'inactive', 'processing'])->default('active')->index();
            
            // User tracking (can be extended to foreign key if User model exists)
            $table->string('uploaded_by')->nullable();
            
            // Timestamps with soft deletes for data integrity
            $table->timestamps();
            $table->softDeletes();
            
            // Composite indexes for common query patterns
            $table->index(['status', 'category']); // For filtered listings
            $table->index(['created_at', 'status']); // For chronological listings
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Drops the documents table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
