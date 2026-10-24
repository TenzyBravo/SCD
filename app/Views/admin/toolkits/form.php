<?php
/** @var array|null $item @var array $categories @var array $errors @var array $old */
use App\Core\View;

$title = $item ? 'Edit resource' : 'Add resource';
$val   = static fn(string $k, $d = '') => $old[$k] ?? ($item[$k] ?? $d);
?>
<h1 class="h3 mb-3"><?= e($title) ?></h1>
<div class="card"><div class="card-body">
<form method="post" enctype="multipart/form-data" action="<?= url($item ? 'admin/toolkits/' . $item['id'] : 'admin/toolkits') ?>" novalidate>
  <?= csrf() ?>
  <div class="row g-3">
    <div class="col-md-8">
      <label class="form-label" for="title">Title</label>
      <input class="form-control<?= invalid($errors, 'title') ?>" id="title" name="title" maxlength="200" value="<?= e($val('title')) ?>" required/>
      <?= errorFor($errors, 'title') ?>
    </div>
    <div class="col-md-4">
      <label class="form-label" for="category">Category</label>
      <select class="form-select<?= invalid($errors, 'category') ?>" id="category" name="category">
<?php foreach ($categories as $key => $name): ?>
        <option value="<?= e($key) ?>"<?= $val('category', 'guideline') === $key ? ' selected' : '' ?>><?= e($name) ?></option>
<?php endforeach; ?>
      </select>
      <?= errorFor($errors, 'category') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="description">Short description <span class="text-muted">(optional)</span></label>
      <textarea class="form-control<?= invalid($errors, 'description') ?>" id="description" name="description" rows="3" maxlength="2000"><?= e($val('description')) ?></textarea>
      <?= errorFor($errors, 'description') ?>
    </div>
    <div class="col-12">
      <label class="form-label" for="file">File <?= $item ? '<span class="text-muted">(choose a file only to replace the current one)</span>' : '' ?></label>
      <input class="form-control<?= invalid($errors, 'file') ?>" id="file" name="file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip"<?= $item ? '' : ' required' ?>/>
      <div class="form-text">PDF, Word, Excel, PowerPoint or ZIP, up to 20 MB.</div>
      <?= errorFor($errors, 'file') ?>
<?php if ($item): ?>
      <div class="small mt-2">Current file: <a href="<?= e(fileUrl($item['file_path'])) ?>"><?= e($item['file_name']) ?></a> (<?= e(bytes((int)$item['file_size'])) ?>)</div>
<?php endif; ?>
    </div>
  </div>
  <?php View::partial('form-footer', ['item' => $item, 'errors' => $errors, 'old' => $old, 'back' => 'admin/toolkits']); ?>
</form>
</div></div>
