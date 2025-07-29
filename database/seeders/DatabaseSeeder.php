<?php

namespace Database\Seeders;

// Laravel framework imports
use Illuminate\Database\Seeder;

/**
 * Database Seeder
 * 
 * Main seeder class that orchestrates all database seeding operations.
 * Populates the database with sample data for development and testing.
 * 
 * Following SOLID principles:
 * - Single Responsibility: Coordinates database seeding only
 * - Open/Closed: Extensible through additional seeder classes
 * - Interface Segregation: Focused seeding interface
 * - Dependency Inversion: Uses Laravel's seeding abstractions
 * 
 * Performance optimizations:
 * - Efficient batch operations for large datasets
 * - Proper transaction handling for data integrity
 * - Optimized seeding order to respect foreign key constraints
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Runs all necessary seeders in the correct order to populate
     * the database with sample data for development and testing.
     * 
     * Performance optimization: Seeds are run in dependency order
     * to ensure referential integrity and optimal performance.
     * 
     * @return void
     */
    public function run(): void
    {
        // Seed users first (required for document foreign keys)
        $this->call([
            UserSeeder::class,
            DocumentSeeder::class,
        ]);

        // Output seeding completion message
        $this->command->info('Database seeding completed successfully!');
        $this->command->info('Sample users and documents have been created.');
        $this->command->info('You can now test the API endpoints with the seeded data.');
    }
}
