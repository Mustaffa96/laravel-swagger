<?php

namespace App\Models;

// Laravel framework imports
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * User Model
 * 
 * Represents a user in the system with authentication capabilities.
 * This model handles user authentication, authorization, and basic user data.
 * 
 * Following SOLID principles:
 * - Single Responsibility: Handles only user-related data and authentication
 * - Open/Closed: Extensible through traits and relationships
 * - Liskov Substitution: Properly extends Authenticatable
 * - Interface Segregation: Implements only necessary interfaces
 * - Dependency Inversion: Uses Laravel's authentication contracts
 * 
 * Performance optimizations:
 * - Uses proper database indexing on email field
 * - Implements efficient attribute casting
 * - Optimized for memory usage with selective fillable fields
 * 
 * @property int $id Primary key identifier
 * @property string $name User's full name
 * @property string $email User's email address (unique)
 * @property \Illuminate\Support\Carbon|null $email_verified_at Email verification timestamp
 * @property string $password Hashed password
 * @property string|null $remember_token Remember me token
 * @property \Illuminate\Support\Carbon|null $created_at Creation timestamp
 * @property \Illuminate\Support\Carbon|null $updated_at Last update timestamp
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * 
     * Security optimization: Only allow specific fields to be mass assigned
     * to prevent mass assignment vulnerabilities.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * 
     * Security optimization: Hide sensitive information from JSON output
     * to prevent accidental exposure of credentials.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * 
     * Performance optimization: Proper type casting for better performance
     * and type safety throughout the application.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the documents uploaded by this user.
     * 
     * Establishes a one-to-many relationship with Document model.
     * Performance optimization: Uses proper foreign key indexing.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    /**
     * Get the user's full name attribute.
     * 
     * Accessor for consistent name formatting across the application.
     * 
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Check if the user has verified their email.
     * 
     * Helper method for email verification status checking.
     * 
     * @return bool
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }
}
