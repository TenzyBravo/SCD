<?php
/**
 * Staff area layout (Bootstrap 5).
 * @var string $content
 * @var string|null $title
 */
use App\Core\Auth;
use App\Core\Flash;

$nav = [
    ['admin',          'Dashboard',      null],
    ['admin/news',     'News & Media',   'news.manage'],
    ['admin/toolkits', 'Toolkits',       'toolkits.manage'],
    ['admin/jobs',     'Jobs',           'jobs.manage'],
    ['admin/training', 'Training',       'training.manage'],
    ['admin/team',     'Team',           'team.manage'],
    ['admin/users',    'Staff accounts', 'users.manage'],
    ['admin/roles',    'Roles',          'roles.manage'],
    ['admin/audit',    'Audit log',      'audit.view'],
];
?><!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="robots" content="noindex, nofollow"/>
<title><?= e(($title ?? 'Admin') . ' — SCD Admin') ?></title>
<link rel="shortcut icon" href="<?= url('assets/images/logo/wnbg.jpeg') ?>"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
<link rel="stylesheet" href="<?= url('css/admin.css') ?>"/>
</head><body class="admin">
<nav class="navbar navbar-expand-xxl navbar-dark admin-bar">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="<?= url('admin') ?>">
      <img src="<?= url('assets/images/logo/wnbg.jpeg') ?>" alt="" width="32" height="32" class="rounded-circle bg-white"/> SCD Admin
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
<?php if (Auth::check() && !Auth::mustChangePassword()): ?>
      <ul class="navbar-nav me-auto">
<?php foreach ($nav as [$path, $label, $perm]): if ($perm !== null && !can($perm)) { continue; } ?>
        <li class="nav-item"><a class="nav-link<?= $path === 'admin' ? (\App\Core\Request::path() === '/admin' ? ' active' : '') : activeIf($path) ?>" href="<?= url($path) ?>"><?= e($label) ?></a></li>
<?php endforeach; ?>
      </ul>
<?php else: ?>
      <div class="me-auto"></div>
<?php endif; ?>
<?php if (Auth::check()): ?>
      <div class="d-flex align-items-center gap-2 text-white-50 small">
        <span><?= e(Auth::name()) ?> · <?= e(Auth::roleName()) ?></span>
        <a class="btn btn-sm btn-outline-light" href="<?= url('admin/password') ?>">Password</a>
        <a class="btn btn-sm btn-outline-light" href="<?= url('index.html') ?>" target="_blank" rel="noopener">View site</a>
        <form method="post" action="<?= url('admin/logout') ?>" class="m-0"><?= csrf() ?><button class="btn btn-sm btn-light">Sign out</button></form>
      </div>
<?php endif; ?>
    </div>
  </div>
</nav>

<main class="container py-4">
<?php foreach (Flash::take() as $flash): ?>
  <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
    <?= e($flash['message']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endforeach; ?>
<?= $content ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?= url('js/admin.js') ?>"></script>
</body></html>
