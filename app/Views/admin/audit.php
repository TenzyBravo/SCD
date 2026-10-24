<?php
/** @var array $entries @var array $page @var array $filters @var array $users @var array $actions */
use App\Core\View;

$title = 'Audit log';
$pretty = static function (?string $json): string {
    if ($json === null || $json === '' || $json === '[]' || $json === '{}') {
        return '';
    }
    $data = json_decode($json, true);
    if (!is_array($data)) {
        return '';
    }
    $lines = [];
    foreach ($data as $k => $v) {
        $lines[] = $k . ': ' . (is_scalar($v) || $v === null ? (string)($v ?? '—') : json_encode($v));
    }
    return implode("\n", $lines);
};
?>
<h1 class="h3 mb-1">Audit log</h1>
<p class="text-muted">Every sign-in, and every change made in this admin area. Entries cannot be edited or deleted.</p>
<form class="row g-2 mb-3" method="get" action="<?= url('admin/audit') ?>">
  <div class="col-sm-4">
    <select class="form-select" name="user_id" aria-label="Staff member">
      <option value="">Everyone</option>
<?php foreach ($users as $u): ?>
      <option value="<?= (int)$u['id'] ?>"<?= $filters['user_id'] === (int)$u['id'] ? ' selected' : '' ?>><?= e($u['name']) ?></option>
<?php endforeach; ?>
    </select>
  </div>
  <div class="col-sm-4">
    <select class="form-select" name="action" aria-label="Action">
      <option value="">All actions</option>
<?php foreach ($actions as $a): ?>
      <option<?= $filters['action'] === $a ? ' selected' : '' ?>><?= e($a) ?></option>
<?php endforeach; ?>
    </select>
  </div>
  <div class="col-sm-4 d-flex gap-2">
    <button class="btn btn-outline-success" type="submit">Filter</button>
    <a class="btn btn-outline-secondary" href="<?= url('admin/audit') ?>">Clear</a>
  </div>
</form>
<div class="card mb-3"><div class="table-responsive"><table class="table table-sm mb-0">
  <thead><tr><th>When</th><th>Who</th><th>Action</th><th>Details</th><th>Before</th><th>After</th><th>IP</th></tr></thead>
  <tbody>
<?php foreach ($entries as $entry): ?>
    <tr>
      <td class="text-nowrap"><?= e(dt($entry['created_at'], 'd M Y H:i')) ?></td>
      <td><?= e($entry['user_name'] ?? '—') ?></td>
      <td><code><?= e($entry['action']) ?></code></td>
      <td><?= e($entry['description']) ?></td>
      <td class="audit-values"><?= e($pretty($entry['old_values'])) ?></td>
      <td class="audit-values"><?= e($pretty($entry['new_values'])) ?></td>
      <td class="small text-muted"><?= e($entry['ip_address']) ?></td>
    </tr>
<?php endforeach; ?>
<?php if ($entries === []): ?>
    <tr><td colspan="7" class="text-muted text-center py-4">No entries match.</td></tr>
<?php endif; ?>
  </tbody>
</table></div></div>
<?php View::partial('pagination', ['page' => $page]); ?>
