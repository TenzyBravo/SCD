<?php
/** @var array|null $item @var array $positions @var array $errors @var array $old */
use App\Core\View;

$title = $item ? 'Edit team member' : 'Add team member';
$val   = static fn(string $k, $d = '') => $old[$k] ?? ($item[$k] ?? $d);
?>
<h1 class="h3 mb-3"><?= e($title) ?></h1>
<div class="card"><div class="card-body">
<form method="post" enctype="multipart/form-data" action="<?= url($item ? 'admin/team/' . $item['id'] : 'admin/team') ?>" novalidate>
  <?= csrf() ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label" for="name">Full name</label>
      <input class="form-control<?= invalid($errors, 'name') ?>" id="name" name="name" maxlength="120" value="<?= e($val('name')) ?>" required/>
      <?= errorFor($errors, 'name') ?>
    </div>
    <div class="col-md-6">
      <label class="form-label" for="title">Role / title</label>
      <input class="form-control<?= invalid($errors, 'title') ?>" id="title" name="title" maxlength="120" placeholder="e.g. Volunteer Board Member" value="<?= e($val('title')) ?>" required/>
      <?= errorFor($errors, 'title') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="bio">Short bio <span class="text-muted">(optional)</span></label>
      <textarea class="form-control<?= invalid($errors, 'bio') ?>" id="bio" name="bio" rows="5" maxlength="1500"><?= e($val('bio')) ?></textarea>
      <div class="form-text">One paragraph, up to 1,500 characters.</div>
      <?= errorFor($errors, 'bio') ?>
    </div>
    <div class="col-md-8">
      <label class="form-label" for="image">Photo <span class="text-muted">(JPG, PNG or WebP — a portrait works best)</span></label>
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
      <label class="form-label" for="image_position">Photo crop</label>
      <select class="form-select<?= invalid($errors, 'image_position') ?>" id="image_position" name="image_position">
<?php foreach ($positions as $key => [$label]): ?>
        <option value="<?= e($key) ?>"<?= $val('image_position', 'top') === $key ? ' selected' : '' ?>><?= e($label) ?></option>
<?php endforeach; ?>
      </select>
      <div class="form-text">Photos are shown as squares; this picks which part stays visible.</div>
      <?= errorFor($errors, 'image_position') ?>
    </div>
  </div>
  <?php View::partial('form-footer', ['item' => $item, 'errors' => $errors, 'old' => $old, 'back' => 'admin/team']); ?>
</form>
</div></div>
