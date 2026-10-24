<?php
/** @var array|null $item @var array $types @var array $errors @var array $old */
use App\Core\View;

$title = $item ? 'Edit story' : 'New story';
$val   = static fn(string $k, $d = '') => $old[$k] ?? ($item[$k] ?? $d);
?>
<h1 class="h3 mb-3"><?= e($title) ?></h1>
<div class="card"><div class="card-body">
<form method="post" enctype="multipart/form-data" action="<?= url($item ? 'admin/news/' . $item['id'] : 'admin/news') ?>" novalidate>
  <?= csrf() ?>
  <div class="row g-3">
    <div class="col-md-8">
      <label class="form-label" for="title">Title</label>
      <input class="form-control<?= invalid($errors, 'title') ?>" id="title" name="title" maxlength="200" value="<?= e($val('title')) ?>" required/>
      <?= errorFor($errors, 'title') ?>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="type">Type</label>
      <select class="form-select<?= invalid($errors, 'type') ?>" id="type" name="type">
<?php foreach ($types as $key => $name): ?>
        <option value="<?= e($key) ?>"<?= $val('type', 'news') === $key ? ' selected' : '' ?>><?= e($name) ?></option>
<?php endforeach; ?>
      </select>
      <?= errorFor($errors, 'type') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="excerpt">Summary <span class="text-muted">(optional)</span></label>
      <textarea class="form-control<?= invalid($errors, 'excerpt') ?>" id="excerpt" name="excerpt" rows="2" maxlength="400"><?= e($val('excerpt')) ?></textarea>
      <div class="form-text">One or two sentences shown on the Media page. Leave empty to use the start of the story.</div>
      <?= errorFor($errors, 'excerpt') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="body">Story text</label>
      <textarea class="form-control<?= invalid($errors, 'body') ?>" id="body" name="body" rows="12" required><?= e($val('body')) ?></textarea>
      <div class="form-text">Leave a blank line between paragraphs.</div>
      <?= errorFor($errors, 'body') ?>
    </div>
    <div class="col-md-8">
      <label class="form-label" for="image">Photo <span class="text-muted">(optional — JPG, PNG or WebP)</span></label>
      <input class="form-control<?= invalid($errors, 'image') ?>" id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp,image/gif"/>
      <?= errorFor($errors, 'image') ?>
<?php if (!empty($item['image_path'])): ?>
      <div class="d-flex align-items-center gap-3 mt-2">
        <img class="form-preview" src="<?= e(fileUrl($item['image_path'])) ?>" alt="Current photo"/>
        <div class="form-check"><input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1"/><label class="form-check-label" for="remove_image">Remove photo</label></div>
      </div>
<?php endif; ?>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="published_on">Publication date <span class="text-muted">(optional)</span></label>
      <input class="form-control<?= invalid($errors, 'published_on') ?>" id="published_on" name="published_on" type="date" value="<?= e($old['published_on'] ?? (isset($item['published_at']) ? substr((string)$item['published_at'], 0, 10) : '')) ?>"/>
      <div class="form-text">Leave empty to use the day it is published. A future date schedules it.</div>
      <?= errorFor($errors, 'published_on') ?>
    </div>
  </div>
  <?php View::partial('form-footer', ['item' => $item, 'errors' => $errors, 'old' => $old, 'back' => 'admin/news', 'noOrder' => true]); ?>
</form>
</div></div>
