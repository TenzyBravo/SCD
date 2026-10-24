<?php
/** @var array $tiles @var array $activity */
use App\Core\Auth;

$title = 'Dashboard';
?>
<h1 class="h3 mb-1">Welcome, <?= e(Auth::name()) ?></h1>
<p class="text-muted">You are signed in as <?= e(Auth::roleName()) ?>.</p>

<?php if ($tiles === []): ?>
<div class="alert alert-secondary">Your role does not include any website sections yet. Ask an administrator for access.</div>
<?php else: ?>
<div class="row g-3 mb-4">
<?php foreach ($tiles as [$label, $path, $published, $drafts]): ?>
  <div class="col-sm-6 col-lg-3">
    <a class="card tile h-100 text-decoration-none" href="<?= url('admin/' . $path) ?>"><div class="card-body">
      <div class="text-muted small"><?= e($label) ?></div>
      <div class="display-6"><?= $published ?></div>
      <div class="small text-muted"><?= $drafts ?> draft<?= $drafts === 1 ? '' : 's' ?></div>
    </div></a>
  </div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (can('audit.view')): ?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>Recent activity</span><a class="small" href="<?= url('admin/audit') ?>">Full audit log</a>
  </div>
  <ul class="list-group list-group-flush">
<?php foreach ($activity as $entry): ?>
    <li class="list-group-item d-flex justify-content-between gap-3">
      <span><strong><?= e($entry['user_name'] ?? 'System') ?></strong> — <?= e($entry['description'] ?? $entry['action']) ?> <span class="text-muted small">(<?= e($entry['action']) ?>)</span></span>
      <span class="text-muted small text-nowrap"><?= e(ago($entry['created_at'])) ?></span>
    </li>
<?php endforeach; ?>
<?php if ($activity === []): ?>
    <li class="list-group-item text-muted">Nothing yet.</li>
<?php endif; ?>
  </ul>
</div>
<?php endif; ?>
