<?php
/**
 * Sign-in and first-run pages.
 * @var string $content
 * @var string|null $title
 */
use App\Core\Flash;
?><!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="robots" content="noindex, nofollow"/>
<title><?= e(($title ?? 'Sign in') . ' — SCD Admin') ?></title>
<link rel="shortcut icon" href="<?= url('assets/images/logo/wnbg.jpeg') ?>"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
<link rel="stylesheet" href="<?= url('css/admin.css') ?>"/>
</head><body class="admin auth-page">
<main class="auth-card card shadow-sm">
  <div class="card-body p-4 p-md-5">
    <div class="text-center mb-4">
      <img src="<?= url('assets/images/logo/wnbg.jpeg') ?>" alt="The Safe Center For Development" width="72" height="72" class="rounded-circle mb-2"/>
      <h1 class="h4 mb-0"><?= e($title ?? 'Staff sign in') ?></h1>
    </div>
<?php foreach (Flash::take() as $flash): ?>
    <div class="alert alert-<?= e($flash['type']) ?>" role="alert"><?= e($flash['message']) ?></div>
<?php endforeach; ?>
<?= $content ?>
  </div>
</main>
</body></html>
