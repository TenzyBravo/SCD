<?php
/**
 * Website configuration.
 *
 * Do not put real passwords here — this file is in version control. Create
 * config/config.local.php on the server instead (see docs/ADMIN-SETUP.md);
 * anything it returns overrides the values below.
 */
declare(strict_types=1);

$root = dirname(__DIR__);

$config = [
    'app' => [
        'name'        => 'The Safe Center For Development',
        'debug'       => false,              // true only on your own computer
        'timezone'    => 'Africa/Lusaka',
        'root'        => $root,
        'uploads'     => $root . '/storage/uploads',
        'logs'        => $root . '/storage/logs',
        'views'       => $root . '/app/Views',
        // Leave null to detect from the request.
        'base_url'    => null,
        'force_https' => true,               // redirect admin pages to https
    ],

    'db' => [
        'host'    => '127.0.0.1',
        'port'    => 3306,
        'name'    => 'scd',
        'user'    => 'scd',
        'pass'    => '',
        'charset' => 'utf8mb4',
    ],

    'security' => [
        'session_name'       => 'SCDSESSID',
        'session_timeout'    => 1800,        // seconds of inactivity before sign-out
        'session_regenerate' => 300,         // rotate the session id every N seconds
        'max_login_attempts' => 5,
        'lockout_minutes'    => 15,
        'password_min'       => 10,
        'csrf_token_name'    => '_token',
        'cookie_samesite'    => 'Lax',
    ],

    'uploads' => [
        'max_bytes' => 20 * 1024 * 1024,     // 20 MB per file
    ],
];

$local = __DIR__ . '/config.local.php';
if (is_file($local)) {
    $override = require $local;
    if (is_array($override)) {
        $config = array_replace_recursive($config, $override);
    }
}

return $config;
