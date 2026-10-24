<?php
/** @var array $rows */
use App\Core\View;
use App\Models\Resource;

$title = 'Toolkits';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h1 class="h3 mb-0">Toolkits</h1><p class="text-muted mb-0">Downloads shown on the <a href="<?= url('toolkits.html') ?>" target="_blank" rel="noopener">Toolkits page</a>.</p></div>
  <a class="btn btn-success" href="<?= url('admin/toolkits/new') ?>">Add resource</a>
</div>
<div class="card"><div class="table-responsive"><table class="table mb-0">
  <thead><tr><th>Title</th><th>Category</th><th>File</th><th>Status</th><th>Order</th><th></th></tr></thead>
  <tbody>
<?php foreach ($rows as $row): ?>
    <tr>
      <td><?= e($row['title']) ?></td>
      <td><?= e(Resource::CATEGORIES[$row['category']] ?? $row['category']) ?></td>
      <td><a href="<?= e(fileUrl($row['file_path'])) ?>"><?= e($row['file_name']) ?></a> <span class="text-muted small">(<?= e(bytes((int)$row['file_size'])) ?>)</span></td>
      <td><?php View::partial('status', ['status' => $row['status']]); ?></td>
      <td><?= (int)$row['sort_order'] ?></td>
      <td class="text-end text-nowrap">
        <a class="btn btn-sm btn-outline-success" href="<?= url('admin/toolkits/' . $row['id'] . '/edit') ?>">Edit</a>
        <?php View::partial('delete', ['action' => url('admin/toolkits/' . $row['id'] . '/delete'), 'what' => $row['title']]); ?>
      </td>
    </tr>
<?php endforeach; ?>
<?php if ($rows === []): ?>
    <tr><td colspan="6" class="text-muted text-center py-4">No resources yet. While there are none, the Toolkits page shows its “coming soon” message.</td></tr>
<?php endif; ?>
  </tbody>
</table></div></div>
