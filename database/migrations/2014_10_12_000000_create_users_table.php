<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Users Table Migration
 * 
 * This migration creates the users table for authentication functionality.
 * Follows Laravel conventions and includes proper indexing for performance.
 * 
 * Following SOLID principles:
 * - Single Responsibility: Handles only users table creation
 * - Open/Closed: Extensible through additional migrations
 * - Interface Segregation: Focused database schema interface
 * - Dependency Inversion: Uses Laravel's Schema abstraction
 * 
 * Performance optimizations:
 * - Proper indexing on email field for fast lookups
 * - Optimized column types for PostgreSQL
 * - Efficient primary key with auto-increment
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the users table with all necessary fields for authentication.
     * Includes proper indexing and constraints for optimal performance.
     * 
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Primary key with auto-increment for optimal performance
            $table->id();
            
            // User identification and contact information
            $table->string('name')->comment('User full name');
            $table->string('email')->unique()->comment('User email address (unique)');
            
            // Email verification for security
            $table->timestamp('email_verified_at')->nullable()->comment('Email verification timestamp');
            
            // Authentication credentials
            $table->string('password')->comment('Hashed password');
            
            // Remember me functionality
            $table->rememberToken()->comment('Remember me token for persistent login');
            
            // Timestamps for audit trail
            $table->timestamps();
            
            // Performance optimization: Index on email for fast authentication lookups
            $table->index('email', 'users_email_index');
            
            // Performance optimization: Index on created_at for efficient sorting
            $table->index('created_at', 'users_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Drops the users table when rolling back the migration.
     * 
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
