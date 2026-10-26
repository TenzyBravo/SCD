<?php
/** @var array $rows */
use App\Core\View;

$title = 'Leadership team';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h1 class="h3 mb-0">Leadership team</h1><p class="text-muted mb-0">People shown under “Leadership Team” on the <a href="<?= url('about.html#leadership') ?>" target="_blank" rel="noopener">About page</a>, in display order.</p></div>
  <a class="btn btn-success" href="<?= url('admin/team/new') ?>">Add person</a>
</div>
<div class="card"><div class="table-responsive"><table class="table mb-0">
  <thead><tr><th></th><th>Name</th><th>Role / title</th><th>Status</th><th>Order</th><th></th></tr></thead>
  <tbody>
<?php foreach ($rows as $row): ?>
    <tr>
      <td><?php if ($row['image_path']): ?><img class="thumb thumb-square" src="<?= e(fileUrl($row['image_path'])) ?>" alt=""/><?php endif; ?></td>
      <td><?= e($row['name']) ?></td>
      <td><?= e($row['title']) ?></td>
      <td><?php View::partial('status', ['status' => $row['status']]); ?></td>
      <td><?= (int)$row['sort_order'] ?></td>
      <td class="text-end text-nowrap">
        <a class="btn btn-sm btn-outline-success" href="<?= url('admin/team/' . $row['id'] . '/edit') ?>">Edit</a>
        <?php View::partial('delete', ['action' => url('admin/team/' . $row['id'] . '/delete'), 'what' => $row['name']]); ?>
      </td>
    </tr>
<?php endforeach; ?>
<?php if ($rows === []): ?>
    <tr><td colspan="6" class="text-muted text-center py-4">Nobody yet. The Leadership Team section on the About page is empty until someone is published.</td></tr>
<?php endif; ?>
  </tbody>
</table></div></div>
