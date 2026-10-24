<?php
/**
 * Front controller for the database-driven parts of the site: the Media,
 * Toolkits, Jobs and Training pages, uploaded files, and the /admin area.
 * Every other page is a static .html file served directly by Apache;
 * .htaccess decides which requests come here.
 */
declare(strict_types=1);

require __DIR__ . '/app/Core/App.php';

use App\Core\App;
use App\Core\Request;
use App\Core\Session;

App::boot();

require __DIR__ . '/app/Core/helpers.php';

$isAdmin = Request::path() === '/admin' || str_starts_with(Request::path(), '/admin/');

if ($isAdmin) {
    $host = strtolower(explode(':', (string)($_SERVER['HTTP_HOST'] ?? ''))[0]);
    if (App::config('app.force_https') && !App::isSecure() && !in_array($host, ['localhost', '127.0.0.1'], true)) {
        header('Location: https://' . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '/'), true, 301);
        exit;
    }
    // Staff pages are personal: never let a proxy or the browser cache them.
    header('Cache-Control: no-store, private');
    header('X-Robots-Tag: noindex, nofollow');
    Session::start();
}

$router = require __DIR__ . '/config/routes.php';
$router->dispatch();
