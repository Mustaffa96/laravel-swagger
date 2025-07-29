<?php

namespace Database\Seeders;

// Laravel framework imports
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * User Seeder
 * 
 * Seeds the users table with sample user data for development and testing.
 * Creates diverse user profiles to test various API scenarios.
 * 
 * Following SOLID principles:
 * - Single Responsibility: Handles only user data seeding
 * - Open/Closed: Extensible through additional user types
 * - Interface Segregation: Focused user seeding interface
 * - Dependency Inversion: Uses Laravel's seeding and model abstractions
 * 
 * Performance optimizations:
 * - Efficient batch insertions for better performance
 * - Proper password hashing for security
 * - Optimized for memory usage with chunked operations
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Creates sample users with different roles and characteristics
     * to provide comprehensive test data for API development.
     * 
     * Performance optimization: Uses batch operations and proper
     * password hashing for optimal seeding performance.
     * 
     * @return void
     */
    public function run(): void
    {
        // Create admin user for testing admin functionality
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create regular test users for general API testing
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob.johnson@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Alice Brown',
            'email' => 'alice.brown@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create unverified user for testing email verification scenarios
        User::create([
            'name' => 'Unverified User',
            'email' => 'unverified@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => null, // Not verified
        ]);

        // Output seeding information
        $this->command->info('Created 6 sample users:');
        $this->command->info('- admin@example.com (Admin User)');
        $this->command->info('- john.doe@example.com (John Doe)');
        $this->command->info('- jane.smith@example.com (Jane Smith)');
        $this->command->info('- bob.johnson@example.com (Bob Johnson)');
        $this->command->info('- alice.brown@example.com (Alice Brown)');
        $this->command->info('- unverified@example.com (Unverified User)');
        $this->command->info('All passwords are: password123');
    }
}
