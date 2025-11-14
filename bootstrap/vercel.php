<?php

/**
 * Vercel Serverless Environment Setup
 * Pre-generate package manifest and setup environment
 */

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

// Pre-generate packages.php to avoid write issues
$packagesContent = '<?php return array (
  \'laravel/tinker\' => 
  array (
    \'providers\' => 
    array (
      0 => \'Laravel\\Tinker\\TinkerServiceProvider\',
    ),
  ),
  \'nesbot/carbon\' => 
  array (
    \'providers\' => 
    array (
      0 => \'Carbon\\Laravel\\ServiceProvider\',
    ),
  ),
  \'nunomaduro/termwind\' => 
  array (
    \'providers\' => 
    array (
      0 => \'Termwind\\Laravel\\TermwindServiceProvider\',
    ),
  ),
  \'spatie/laravel-permission\' => 
  array (
    \'providers\' => 
    array (
      0 => \'Spatie\\Permission\\PermissionServiceProvider\',
    ),
  ),
);';

file_put_contents('/tmp/bootstrap/cache/packages.php', $packagesContent);

// Also create services.php to prevent other cache issues
$servicesContent = '<?php return [];';
file_put_contents('/tmp/bootstrap/cache/services.php', $servicesContent);

// Override Laravel paths using environment variables
putenv('LARAVEL_BOOTSTRAP_CACHE=/tmp/bootstrap/cache');
$_ENV['LARAVEL_BOOTSTRAP_CACHE'] = '/tmp/bootstrap/cache';
$_SERVER['LARAVEL_BOOTSTRAP_CACHE'] = '/tmp/bootstrap/cache';

// Set app running in serverless
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Set critical Laravel environment variables if not present
if (!isset($_ENV['APP_KEY'])) {
    // Try to get from server environment or set a default for testing
    $_ENV['APP_KEY'] = $_SERVER['APP_KEY'] ?? 'base64:YourAppKeyHereForTesting1234567890=';
    putenv('APP_KEY=' . $_ENV['APP_KEY']);
}

if (!isset($_ENV['APP_URL'])) {
    $_ENV['APP_URL'] = 'https://contractor-test.vercel.app';
    putenv('APP_URL=' . $_ENV['APP_URL']);
}

// Disable problematic drivers for serverless
$_ENV['BROADCAST_DRIVER'] = 'log';
$_ENV['QUEUE_CONNECTION'] = 'sync';
$_ENV['MAIL_MAILER'] = 'log';
putenv('BROADCAST_DRIVER=log');
putenv('QUEUE_CONNECTION=sync');
putenv('MAIL_MAILER=log');
