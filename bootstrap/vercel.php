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

// Create services.php with proper Laravel core services
$servicesContent = '<?php return [
    \'providers\' => [
        \'Illuminate\\Auth\\AuthServiceProvider\' => \'auth\',
        \'Illuminate\\Broadcasting\\BroadcastServiceProvider\' => \'broadcast\',
        \'Illuminate\\Bus\\BusServiceProvider\' => \'bus\',
        \'Illuminate\\Cache\\CacheServiceProvider\' => \'cache\',
        \'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider\' => \'console\',
        \'Illuminate\\Cookie\\CookieServiceProvider\' => \'cookie\',
        \'Illuminate\\Database\\DatabaseServiceProvider\' => \'database\',
        \'Illuminate\\Encryption\\EncryptionServiceProvider\' => \'encryption\',
        \'Illuminate\\Filesystem\\FilesystemServiceProvider\' => \'filesystem\',
        \'Illuminate\\Foundation\\Providers\\FoundationServiceProvider\' => \'foundation\',
        \'Illuminate\\Hashing\\HashServiceProvider\' => \'hash\',
        \'Illuminate\\Mail\\MailServiceProvider\' => \'mail\',
        \'Illuminate\\Notifications\\NotificationServiceProvider\' => \'notifications\',
        \'Illuminate\\Pagination\\PaginationServiceProvider\' => \'pagination\',
        \'Illuminate\\Pipeline\\PipelineServiceProvider\' => \'pipeline\',
        \'Illuminate\\Queue\\QueueServiceProvider\' => \'queue\',
        \'Illuminate\\Redis\\RedisServiceProvider\' => \'redis\',
        \'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider\' => \'password\',
        \'Illuminate\\Session\\SessionServiceProvider\' => \'session\',
        \'Illuminate\\Translation\\TranslationServiceProvider\' => \'translation\',
        \'Illuminate\\Validation\\ValidationServiceProvider\' => \'validation\',
        \'Illuminate\\View\\ViewServiceProvider\' => \'view\'
    ],
    \'eager\' => [
        \'Illuminate\\Auth\\AuthServiceProvider\',
        \'Illuminate\\Cookie\\CookieServiceProvider\',
        \'Illuminate\\Database\\DatabaseServiceProvider\',
        \'Illuminate\\Encryption\\EncryptionServiceProvider\',
        \'Illuminate\\Filesystem\\FilesystemServiceProvider\',
        \'Illuminate\\Foundation\\Providers\\FoundationServiceProvider\',
        \'Illuminate\\Notifications\\NotificationServiceProvider\',
        \'Illuminate\\Pagination\\PaginationServiceProvider\',
        \'Illuminate\\Session\\SessionServiceProvider\',
        \'Illuminate\\View\\ViewServiceProvider\'
    ],
    \'deferred\' => [
        \'auth\' => \'Illuminate\\Auth\\AuthServiceProvider\',
        \'cache\' => \'Illuminate\\Cache\\CacheServiceProvider\',
        \'view\' => \'Illuminate\\View\\ViewServiceProvider\'
    ]
];';
file_put_contents('/tmp/bootstrap/cache/services.php', $servicesContent);

// Create basic config cache to prevent config loading issues
$configContent = '<?php return [
    "app" => [
        "name" => "Contractor App",
        "env" => "production",
        "debug" => true,
        "url" => "https://contractor-test.vercel.app",
        "timezone" => "UTC",
        "locale" => "en",
        "fallback_locale" => "en",
        "faker_locale" => "en_US",
        "cipher" => "AES-256-CBC",
        "key" => "' . ($_ENV['APP_KEY'] ?? 'base64:YourAppKeyHereForTesting1234567890=') . '",
        "previous_keys" => [],
        "maintenance" => [
            "driver" => "file"
        ],
        "providers" => [
            "Illuminate\\Auth\\AuthServiceProvider",
            "Illuminate\\Broadcasting\\BroadcastServiceProvider", 
            "Illuminate\\Bus\\BusServiceProvider",
            "Illuminate\\Cache\\CacheServiceProvider",
            "Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider",
            "Illuminate\\Cookie\\CookieServiceProvider",
            "Illuminate\\Database\\DatabaseServiceProvider",
            "Illuminate\\Encryption\\EncryptionServiceProvider", 
            "Illuminate\\Filesystem\\FilesystemServiceProvider",
            "Illuminate\\Foundation\\Providers\\FoundationServiceProvider",
            "Illuminate\\Hashing\\HashServiceProvider",
            "Illuminate\\Mail\\MailServiceProvider",
            "Illuminate\\Notifications\\NotificationServiceProvider",
            "Illuminate\\Pagination\\PaginationServiceProvider",
            "Illuminate\\Pipeline\\PipelineServiceProvider",
            "Illuminate\\Queue\\QueueServiceProvider",
            "Illuminate\\Redis\\RedisServiceProvider",
            "Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider", 
            "Illuminate\\Session\\SessionServiceProvider",
            "Illuminate\\Translation\\TranslationServiceProvider",
            "Illuminate\\Validation\\ValidationServiceProvider",
            "Illuminate\\View\\ViewServiceProvider",
            "App\\Providers\\AppServiceProvider",
            "App\\Providers\\ServerlessServiceProvider"
        ]
    ]
];';
file_put_contents('/tmp/bootstrap/cache/config.php', $configContent);

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
