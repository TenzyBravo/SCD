<?php /** @var array|null $item @var array $errors @var array $old @var string $back */ ?>
<div class="row g-3 mt-1">
  <div class="col-sm-6">
    <label class="form-label" for="status">Status</label>
    <select class="form-select<?= invalid($errors, 'status') ?>" id="status" name="status">
<?php $current = $old['status'] ?? ($item['status'] ?? 'draft'); ?>
      <option value="draft"<?= $current === 'draft' ? ' selected' : '' ?>>Draft — not on the website</option>
      <option value="published"<?= $current === 'published' ? ' selected' : '' ?>>Published — visible on the website</option>
    </select>
    <?= errorFor($errors, 'status') ?>
  </div>
<?php if (!isset($noOrder)): ?>
  <div class="col-sm-6">
    <label class="form-label" for="sort_order">Display order</label>
    <input class="form-control<?= invalid($errors, 'sort_order') ?>" id="sort_order" name="sort_order" type="number" min="0" max="9999" value="<?= old($old, 'sort_order', $item['sort_order'] ?? 0) ?>"/>
    <div class="form-text">Lower numbers appear first.</div>
    <?= errorFor($errors, 'sort_order') ?>
  </div>
<?php endif; ?>
</div>
<div class="mt-4 d-flex gap-2">
  <button class="btn btn-success" type="submit">Save</button>
  <a class="btn btn-outline-secondary" href="<?= url($back) ?>">Cancel</a>
</div>
