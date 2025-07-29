<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Password Reset Tokens Table Migration
 * 
 * This migration creates the password_reset_tokens table for password reset functionality.
 * Follows Laravel conventions and includes proper indexing for performance.
 * 
 * Following SOLID principles:
 * - Single Responsibility: Handles only password reset tokens table creation
 * - Open/Closed: Extensible through additional migrations
 * - Interface Segregation: Focused database schema interface
 * - Dependency Inversion: Uses Laravel's Schema abstraction
 * 
 * Performance optimizations:
 * - Proper indexing on email field for fast lookups
 * - Optimized column types for PostgreSQL
 * - Efficient token storage with proper constraints
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Creates the password_reset_tokens table with all necessary fields.
     * Includes proper indexing and constraints for optimal performance.
     * 
     * @return void
     */
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Email as primary identifier for password reset
            $table->string('email')->primary()->comment('User email address');
            
            // Reset token for security
            $table->string('token')->comment('Password reset token');
            
            // Timestamp for token expiry
            $table->timestamp('created_at')->nullable()->comment('Token creation timestamp');
            
            // Performance optimization: Index on created_at for efficient cleanup
            $table->index('created_at', 'password_reset_tokens_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Drops the password_reset_tokens table when rolling back the migration.
     * 
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};
