<?php
/** @var array $rows */
use App\Core\View;

$title = 'Training';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h1 class="h3 mb-0">Training</h1><p class="text-muted mb-0">Courses shown on the <a href="<?= url('training.html') ?>" target="_blank" rel="noopener">Training page</a> and in its registration form.</p></div>
  <a class="btn btn-success" href="<?= url('admin/training/new') ?>">Add course</a>
</div>
<div class="card"><div class="table-responsive"><table class="table mb-0">
  <thead><tr><th></th><th>Course</th><th>Format</th><th>Status</th><th>Order</th><th></th></tr></thead>
  <tbody>
<?php foreach ($rows as $row): ?>
    <tr>
      <td><?php if ($row['image_path']): ?><img class="thumb" src="<?= e(fileUrl($row['image_path'])) ?>" alt=""/><?php endif; ?></td>
      <td><?= e($row['title']) ?><div class="small text-muted"><?= e($row['details']) ?></div></td>
      <td><?= e($row['tag'] ?? '—') ?></td>
      <td><?php View::partial('status', ['status' => $row['status']]); ?></td>
      <td><?= (int)$row['sort_order'] ?></td>
      <td class="text-end text-nowrap">
        <a class="btn btn-sm btn-outline-success" href="<?= url('admin/training/' . $row['id'] . '/edit') ?>">Edit</a>
        <?php View::partial('delete', ['action' => url('admin/training/' . $row['id'] . '/delete'), 'what' => $row['title']]); ?>
      </td>
    </tr>
<?php endforeach; ?>
<?php if ($rows === []): ?>
    <tr><td colspan="6" class="text-muted text-center py-4">No courses yet.</td></tr>
<?php endif; ?>
  </tbody>
</table></div></div>
