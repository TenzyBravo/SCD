<?php
/** @var array|null $item @var array $errors @var array $old */
use App\Core\View;

$title = $item ? 'Edit vacancy' : 'Add vacancy';
$val   = static fn(string $k, $d = '') => $old[$k] ?? ($item[$k] ?? $d);
?>
<h1 class="h3 mb-3"><?= e($title) ?></h1>
<div class="card"><div class="card-body">
<form method="post" action="<?= url($item ? 'admin/jobs/' . $item['id'] : 'admin/jobs') ?>" novalidate>
  <?= csrf() ?>
  <div class="row g-3">
    <div class="col-12">
      <label class="form-label" for="title">Job title</label>
      <input class="form-control<?= invalid($errors, 'title') ?>" id="title" name="title" maxlength="200" value="<?= e($val('title')) ?>" required/>
      <?= errorFor($errors, 'title') ?>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="location">Location</label>
      <input class="form-control<?= invalid($errors, 'location') ?>" id="location" name="location" maxlength="120" placeholder="e.g. Ndola, or Remote — Worldwide" value="<?= e($val('location')) ?>"/>
      <?= errorFor($errors, 'location') ?>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="commitment">Type / hours</label>
      <input class="form-control<?= invalid($errors, 'commitment') ?>" id="commitment" name="commitment" maxlength="160" placeholder="e.g. Full-time, or Voluntary role" value="<?= e($val('commitment')) ?>"/>
      <?= errorFor($errors, 'commitment') ?>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="deadline">Application deadline</label>
      <input class="form-control<?= invalid($errors, 'deadline') ?>" id="deadline" name="deadline" type="date" value="<?= e($val('deadline')) ?>"/>
      <div class="form-text">Leave empty for rolling applications.</div>
      <?= errorFor($errors, 'deadline') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="description">Description</label>
      <textarea class="form-control<?= invalid($errors, 'description') ?>" id="description" name="description" rows="6" maxlength="4000" required><?= e($val('description')) ?></textarea>
      <?= errorFor($errors, 'description') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="how_to_apply">How to apply <span class="text-muted">(optional)</span></label>
      <textarea class="form-control<?= invalid($errors, 'how_to_apply') ?>" id="how_to_apply" name="how_to_apply" rows="2" maxlength="2000"><?= e($val('how_to_apply')) ?></textarea>
      <div class="form-text">Email addresses become clickable. Applicants can always use the application form on the Jobs page too.</div>
      <?= errorFor($errors, 'how_to_apply') ?>
    </div>
  </div>
  <?php View::partial('form-footer', ['item' => $item, 'errors' => $errors, 'old' => $old, 'back' => 'admin/jobs']); ?>
</form>
</div></div>
