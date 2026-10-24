<?php
/** @var array $rows */
use App\Core\View;
use App\Models\Post;

$title = 'News & Media';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h1 class="h3 mb-0">News &amp; Media</h1><p class="text-muted mb-0">Stories shown on the <a href="<?= url('media.html') ?>" target="_blank" rel="noopener">Media page</a>.</p></div>
  <a class="btn btn-success" href="<?= url('admin/news/new') ?>">New story</a>
</div>
<div class="card"><div class="table-responsive"><table class="table mb-0">
  <thead><tr><th></th><th>Title</th><th>Type</th><th>Status</th><th>Date</th><th>Last edited by</th><th></th></tr></thead>
  <tbody>
<?php foreach ($rows as $row): ?>
    <tr>
      <td><?php if ($row['image_path']): ?><img class="thumb" src="<?= e(fileUrl($row['image_path'])) ?>" alt=""/><?php endif; ?></td>
      <td><?= e($row['title']) ?></td>
      <td><?= e(Post::TYPES[$row['type']] ?? $row['type']) ?></td>
      <td><?php View::partial('status', ['status' => $row['status']]); ?></td>
      <td class="text-nowrap"><?= e(d($row['published_at'])) ?></td>
      <td><?= e($row['editor_name'] ?? '—') ?></td>
      <td class="text-end text-nowrap">
<?php if ($row['status'] === 'published'): ?>
        <a class="btn btn-sm btn-outline-secondary" href="<?= url('media/' . rawurlencode($row['slug'])) ?>" target="_blank" rel="noopener">View</a>
<?php endif; ?>
        <a class="btn btn-sm btn-outline-success" href="<?= url('admin/news/' . $row['id'] . '/edit') ?>">Edit</a>
        <?php View::partial('delete', ['action' => url('admin/news/' . $row['id'] . '/delete'), 'what' => $row['title']]); ?>
      </td>
    </tr>
<?php endforeach; ?>
<?php if ($rows === []): ?>
    <tr><td colspan="7" class="text-muted text-center py-4">No stories yet. While there are none, the Media page shows its “coming soon” message.</td></tr>
<?php endif; ?>
  </tbody>
</table></div></div>
