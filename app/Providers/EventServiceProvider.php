<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * Event Service Provider
 * 
 * Registers event listeners and subscribers for the application.
 * Handles application events with proper separation of concerns.
 * 
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     * 
     * Maps events to their corresponding listeners for decoupled handling.
     * Enables clean event-driven architecture patterns.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Document-related events (can be extended)
        // 'App\Events\DocumentUploaded' => [
        //     'App\Listeners\ProcessDocumentUpload',
        //     'App\Listeners\NotifyDocumentUpload',
        // ],
        
        // 'App\Events\DocumentDeleted' => [
        //     'App\Listeners\CleanupDocumentFiles',
        //     'App\Listeners\LogDocumentDeletion',
        // ],
    ];

    /**
     * Register any events for your application.
     * 
     * Registers custom event listeners and model observers.
     * Can be used for complex business logic handling.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register model observers for automatic event handling
        // Document::observe(DocumentObserver::class);
        
        // Register custom event listeners
        // Event::listen('document.uploaded', function ($document) {
        //     // Handle document upload completion
        //     Log::info('Document uploaded: ' . $document->title);
        // });
        
        // Event::listen('document.downloaded', function ($document) {
        //     // Handle document download tracking
        //     Log::info('Document downloaded: ' . $document->title);
        // });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     * 
     * Enables automatic discovery of event listeners in the Listeners directory.
     * Improves developer experience by reducing manual registration.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false; // Set to true to enable automatic event discovery
    }
}
