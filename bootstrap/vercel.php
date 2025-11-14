<?php

/**
 * Vercel Serverless Environment Setup
 * Runs before Laravel bootstrap to setup writable directories
 */

// Only run in Vercel environment
if (!isset($_ENV['VERCEL']) && !isset($_SERVER['VERCEL'])) {
    return;
}

// Create writable directories for Laravel in serverless environment
$tmpDirs = [
    '/tmp/bootstrap',
    '/tmp/bootstrap/cache', 
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions', 
    '/tmp/storage/framework/views',
    '/tmp/storage/logs'
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Override Laravel's default bootstrap cache path
if (!defined('LARAVEL_BOOTSTRAP_CACHE')) {
    define('LARAVEL_BOOTSTRAP_CACHE', '/tmp/bootstrap/cache');
}

// Override storage path for Laravel
if (!defined('LARAVEL_STORAGE_PATH')) {
    define('LARAVEL_STORAGE_PATH', '/tmp/storage');
}

// Set up environment for package manifest
putenv('LARAVEL_BOOTSTRAP_CACHE=/tmp/bootstrap/cache');
$_ENV['LARAVEL_BOOTSTRAP_CACHE'] = '/tmp/bootstrap/cache';
$_SERVER['LARAVEL_BOOTSTRAP_CACHE'] = '/tmp/bootstrap/cache';
