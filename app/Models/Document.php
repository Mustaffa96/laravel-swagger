<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Document Model
 * 
 * Represents a document entity with file upload/download capabilities.
 * Follows SOLID principles with single responsibility for document management.
 * 
 * @package App\Models
 */
class Document extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * Following the principle of explicit mass assignment protection
     * to prevent security vulnerabilities.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'category',
        'status',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     * 
     * Ensures proper data type handling for performance optimization.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * 
     * Security measure to prevent sensitive data exposure.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'file_path', // Hide actual file path for security
    ];

    /**
     * The accessors to append to the model's array form.
     * 
     * Provides computed attributes for API responses.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'download_url',
        'file_size_human',
    ];

    /**
     * Get the download URL for the document.
     * 
     * Provides a secure way to access file downloads.
     *
     * @return string
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('documents.download', $this->id);
    }

    /**
     * Get human-readable file size.
     * 
     * Enhances user experience with readable file sizes.
     *
     * @return string
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope a query to only include active documents.
     * 
     * Performance optimization for common queries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by category.
     * 
     * Enables efficient category-based filtering.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Check if the document file exists.
     * 
     * Validates file integrity before operations.
     *
     * @return bool
     */
    public function fileExists(): bool
    {
        return $this->file_path && file_exists(storage_path('app/' . $this->file_path));
    }

    /**
     * Get the full file path.
     * 
     * Provides secure access to file system path.
     *
     * @return string|null
     */
    public function getFullFilePath(): ?string
    {
        return $this->file_path ? storage_path('app/' . $this->file_path) : null;
    }
}
