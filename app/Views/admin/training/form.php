<?php
/** @var array|null $item @var array $errors @var array $old */
use App\Core\View;

$title = $item ? 'Edit course' : 'Add course';
$val   = static fn(string $k, $d = '') => $old[$k] ?? ($item[$k] ?? $d);
?>
<h1 class="h3 mb-3"><?= e($title) ?></h1>
<div class="card"><div class="card-body">
<form method="post" enctype="multipart/form-data" action="<?= url($item ? 'admin/training/' . $item['id'] : 'admin/training') ?>" novalidate>
  <?= csrf() ?>
  <div class="row g-3">
    <div class="col-md-8">
      <label class="form-label" for="title">Course name</label>
      <input class="form-control<?= invalid($errors, 'title') ?>" id="title" name="title" maxlength="200" value="<?= e($val('title')) ?>" required/>
      <?= errorFor($errors, 'title') ?>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="tag">Format / location</label>
      <input class="form-control<?= invalid($errors, 'tag') ?>" id="tag" name="tag" maxlength="80" placeholder="e.g. Online, or In-person · Ndola" value="<?= e($val('tag')) ?>"/>
      <?= errorFor($errors, 'tag') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="details">Details</label>
      <input class="form-control<?= invalid($errors, 'details') ?>" id="details" name="details" maxlength="400" placeholder="e.g. 2-day intensive · May 8–9, 2026 · Ndola." value="<?= e($val('details')) ?>" required/>
      <?= errorFor($errors, 'details') ?>
    </div>
    <div class="col-12">
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
  </div>
  <?php View::partial('form-footer', ['item' => $item, 'errors' => $errors, 'old' => $old, 'back' => 'admin/training']); ?>
</form>
</div></div>
