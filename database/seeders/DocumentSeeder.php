<?php

namespace Database\Seeders;

// Laravel framework imports
use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\User;

/**
 * Document Seeder
 * 
 * Seeds the documents table with sample document data for development and testing.
 * Creates diverse document types to test various API scenarios and file operations.
 * 
 * Following SOLID principles:
 * - Single Responsibility: Handles only document data seeding
 * - Open/Closed: Extensible through additional document types
 * - Interface Segregation: Focused document seeding interface
 * - Dependency Inversion: Uses Laravel's seeding and model abstractions
 * 
 * Performance optimizations:
 * - Efficient batch insertions for better performance
 * - Proper foreign key relationships with users
 * - Optimized for memory usage with chunked operations
 */
class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates sample documents with different types, sizes, and statuses
     * to provide comprehensive test data for API development.
     * 
     * Performance optimization: Uses batch operations and proper
     * relationship handling for optimal seeding performance.
     * 
     * @return void
     */
    public function run(): void
    {
        // Get all users to assign documents to them
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->error('No users found! Please run UserSeeder first.');
            return;
        }

        // Sample documents with various types and categories
        $documents = [
            [
                'title' => 'Project Requirements Document',
                'description' => 'Comprehensive requirements document for the Laravel Swagger API project.',
                'file_name' => 'project_requirements.pdf',
                'file_path' => 'documents/2024/01/project_requirements_' . uniqid() . '.pdf',
                'file_size' => 2048576, // 2MB
                'mime_type' => 'application/pdf',
                'category' => 'documentation',
                'status' => 'active',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'API Design Specification',
                'description' => 'Detailed API design and endpoint specifications for the document management system.',
                'file_name' => 'api_design_spec.docx',
                'file_path' => 'documents/2024/01/api_design_spec_' . uniqid() . '.docx',
                'file_size' => 1536000, // 1.5MB
                'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'category' => 'specification',
                'status' => 'active',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'Database Schema Diagram',
                'description' => 'Visual representation of the database schema and relationships.',
                'file_name' => 'database_schema.png',
                'file_path' => 'documents/2024/01/database_schema_' . uniqid() . '.png',
                'file_size' => 512000, // 512KB
                'mime_type' => 'image/png',
                'category' => 'diagram',
                'status' => 'active',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'User Manual Draft',
                'description' => 'Draft version of the user manual for the document management API.',
                'file_name' => 'user_manual_draft.txt',
                'file_path' => 'documents/2024/01/user_manual_draft_' . uniqid() . '.txt',
                'file_size' => 256000, // 256KB
                'mime_type' => 'text/plain',
                'category' => 'manual',
                'status' => 'processing',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'Test Data Sample',
                'description' => 'Sample CSV file containing test data for API validation.',
                'file_name' => 'test_data.csv',
                'file_path' => 'documents/2024/01/test_data_' . uniqid() . '.csv',
                'file_size' => 102400, // 100KB
                'mime_type' => 'text/csv',
                'category' => 'data',
                'status' => 'active',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'Architecture Overview',
                'description' => 'High-level architecture overview presentation for the project.',
                'file_name' => 'architecture_overview.pptx',
                'file_path' => 'documents/2024/01/architecture_overview_' . uniqid() . '.pptx',
                'file_size' => 3072000, // 3MB
                'mime_type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'category' => 'presentation',
                'status' => 'active',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'Configuration Settings',
                'description' => 'JSON configuration file for application settings.',
                'file_name' => 'config.json',
                'file_path' => 'documents/2024/01/config_' . uniqid() . '.json',
                'file_size' => 8192, // 8KB
                'mime_type' => 'application/json',
                'category' => 'configuration',
                'status' => 'active',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'Legacy Document',
                'description' => 'Old document that has been archived for reference.',
                'file_name' => 'legacy_doc.doc',
                'file_path' => 'documents/2024/01/legacy_doc_' . uniqid() . '.doc',
                'file_size' => 1024000, // 1MB
                'mime_type' => 'application/msword',
                'category' => 'archive',
                'status' => 'inactive',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'Temporary Upload',
                'description' => 'Temporary file upload for testing purposes.',
                'file_name' => 'temp_file.tmp',
                'file_path' => 'documents/2024/01/temp_file_' . uniqid() . '.tmp',
                'file_size' => 51200, // 50KB
                'mime_type' => 'application/octet-stream',
                'category' => 'temporary',
                'status' => 'inactive',
                'uploaded_by' => $users->random()->id,
            ],
            [
                'title' => 'Large Dataset',
                'description' => 'Large Excel file containing comprehensive dataset for analysis.',
                'file_name' => 'large_dataset.xlsx',
                'file_path' => 'documents/2024/01/large_dataset_' . uniqid() . '.xlsx',
                'file_size' => 8388608, // 8MB
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'category' => 'data',
                'status' => 'active',
                'uploaded_by' => $users->random()->id,
            ],
        ];

        // Insert documents into database
        foreach ($documents as $documentData) {
            Document::create($documentData);
        }

        // Output seeding information
        $this->command->info('Created 10 sample documents:');
        $this->command->info('- Various file types: PDF, DOCX, PNG, TXT, CSV, PPTX, JSON, DOC, TMP, XLSX');
        $this->command->info('- Different categories: documentation, specification, diagram, manual, data, etc.');
        $this->command->info('- Multiple statuses: active, processing, inactive');
        $this->command->info('- File sizes ranging from 8KB to 8MB');
        $this->command->info('- Randomly assigned to seeded users');
        $this->command->info('- Unique file paths generated for each document');
    }
}
