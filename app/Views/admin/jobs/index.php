<?php
/** @var array $rows */
use App\Core\View;

$title = 'Jobs';
$today = date('Y-m-d');
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h1 class="h3 mb-0">Jobs</h1><p class="text-muted mb-0">Vacancies shown on the <a href="<?= url('jobs.html') ?>" target="_blank" rel="noopener">Jobs page</a>. A vacancy leaves the website automatically the day after its deadline.</p></div>
  <a class="btn btn-success" href="<?= url('admin/jobs/new') ?>">Add vacancy</a>
</div>
<div class="card"><div class="table-responsive"><table class="table mb-0">
  <thead><tr><th>Title</th><th>Location</th><th>Deadline</th><th>Status</th><th>Order</th><th></th></tr></thead>
  <tbody>
<?php foreach ($rows as $row): $expired = $row['deadline'] !== null && $row['deadline'] < $today; ?>
    <tr>
      <td><?= e($row['title']) ?></td>
      <td><?= e($row['location'] ?? '—') ?></td>
      <td class="text-nowrap"><?= $row['deadline'] ? e(d($row['deadline'])) : 'Rolling' ?><?php if ($expired): ?> <span class="badge text-bg-warning">Closed</span><?php endif; ?></td>
      <td><?php View::partial('status', ['status' => $row['status']]); ?></td>
      <td><?= (int)$row['sort_order'] ?></td>
      <td class="text-end text-nowrap">
        <a class="btn btn-sm btn-outline-success" href="<?= url('admin/jobs/' . $row['id'] . '/edit') ?>">Edit</a>
        <?php View::partial('delete', ['action' => url('admin/jobs/' . $row['id'] . '/delete'), 'what' => $row['title']]); ?>
      </td>
    </tr>
<?php endforeach; ?>
<?php if ($rows === []): ?>
    <tr><td colspan="6" class="text-muted text-center py-4">No vacancies. While none are open, the Jobs page invites people to join the talent pool.</td></tr>
<?php endif; ?>
  </tbody>
</table></div></div>
