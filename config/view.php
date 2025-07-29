<?php

/**
 * View Configuration
 * 
 * This file contains the configuration for Laravel's view system.
 * It defines where view files are located and how they should be compiled.
 * 
 * Following SOLID principles:
 * - Single Responsibility: Handles only view configuration
 * - Open/Closed: Extensible through custom view paths
 * - Interface Segregation: Focused configuration interface
 * - Dependency Inversion: Abstracts view location details
 */

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    | Performance optimization: Paths are checked in order, place most
    | commonly used paths first to reduce filesystem lookups.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    | Performance optimization: Uses storage path for faster access and
    | better separation of concerns.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
