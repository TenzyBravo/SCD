<?php
/**
 * Route table. Only the paths that .htaccess sends to index.php can reach
 * these routes; every other page of the site is a plain .html file.
 */
declare(strict_types=1);

use App\Core\Router;

$r = new Router();

// ---------------------------------------------------------------- public pages
$r->get('/media.html',     ['SiteController', 'media']);
$r->get('/media/{slug}',   ['SiteController', 'post']);
$r->get('/toolkits.html',  ['SiteController', 'toolkits']);
$r->get('/jobs.html',      ['SiteController', 'jobs']);
$r->get('/training.html',  ['SiteController', 'training']);
$r->get('/uploads/{file}', ['UploadController', 'show']);

// ---------------------------------------------------------------- sign-in
$r->get('/admin/setup',  ['AuthController', 'setupForm']);
$r->post('/admin/setup', ['AuthController', 'setup']);
$r->get('/admin/login',  ['AuthController', 'loginForm'], ['guest']);
$r->post('/admin/login', ['AuthController', 'login'],     ['guest']);
$r->post('/admin/logout', ['AuthController', 'logout'],   ['auth']);
$r->get('/admin/password',  ['AuthController', 'passwordForm'], ['auth']);
$r->post('/admin/password', ['AuthController', 'password'],     ['auth']);

// ---------------------------------------------------------------- dashboard
$r->get('/admin', ['Admin\\DashboardController', 'index'], ['auth']);

// ---------------------------------------------------------------- content
$content = [
    'news'     => ['Admin\\PostsController',     'news.manage'],
    'toolkits' => ['Admin\\ResourcesController', 'toolkits.manage'],
    'jobs'     => ['Admin\\JobsController',      'jobs.manage'],
    'training' => ['Admin\\CoursesController',   'training.manage'],
];
foreach ($content as $path => [$controller, $permission]) {
    $mw = ['can:' . $permission];
    $r->get("/admin/$path",              [$controller, 'index'],   $mw);
    $r->get("/admin/$path/new",          [$controller, 'create'],  $mw);
    $r->post("/admin/$path",             [$controller, 'store'],   $mw);
    $r->get("/admin/$path/{id}/edit",    [$controller, 'edit'],    $mw);
    $r->post("/admin/$path/{id}",        [$controller, 'update'],  $mw);
    $r->post("/admin/$path/{id}/delete", [$controller, 'destroy'], $mw);
}

// ---------------------------------------------------------------- staff + roles
$r->get('/admin/users',           ['Admin\\UsersController', 'index'],  ['can:users.manage']);
$r->get('/admin/users/new',       ['Admin\\UsersController', 'create'], ['can:users.manage']);
$r->post('/admin/users',          ['Admin\\UsersController', 'store'],  ['can:users.manage']);
$r->get('/admin/users/{id}/edit', ['Admin\\UsersController', 'edit'],   ['can:users.manage']);
$r->post('/admin/users/{id}',     ['Admin\\UsersController', 'update'], ['can:users.manage']);

$r->get('/admin/roles',  ['Admin\\RolesController', 'index'],  ['can:roles.manage']);
$r->post('/admin/roles', ['Admin\\RolesController', 'update'], ['can:roles.manage']);

$r->get('/admin/audit', ['Admin\\AuditController', 'index'], ['can:audit.view']);

return $r;
