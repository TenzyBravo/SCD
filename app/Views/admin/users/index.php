<?php
/** @var array $users */
use App\Core\Auth;

$title = 'Staff accounts';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div><h1 class="h3 mb-0">Staff accounts</h1><p class="text-muted mb-0">Who can sign in to this admin area, and what their role lets them do (<a href="<?= url('admin/roles') ?>">see roles</a>).</p></div>
  <a class="btn btn-success" href="<?= url('admin/users/new') ?>">Add staff member</a>
</div>
<div class="card"><div class="table-responsive"><table class="table mb-0">
  <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Last sign-in</th><th></th></tr></thead>
  <tbody>
<?php foreach ($users as $user): ?>
    <tr>
      <td><?= e($user['name']) ?><?php if ((int)$user['id'] === Auth::id()): ?> <span class="badge text-bg-light">You</span><?php endif; ?></td>
      <td><?= e($user['email']) ?></td>
      <td><?= e($user['role_name']) ?></td>
      <td>
        <span class="badge text-bg-<?= $user['status'] === 'active' ? 'success' : 'danger' ?>"><?= $user['status'] === 'active' ? 'Active' : 'Suspended' ?></span>
<?php if ($user['locked_until'] !== null && strtotime((string)$user['locked_until']) > time()): ?> <span class="badge text-bg-warning">Locked out</span><?php endif; ?>
<?php if ($user['must_change_password']): ?> <span class="badge text-bg-info">Temporary password</span><?php endif; ?>
      </td>
      <td class="text-nowrap"><?= e(dt($user['last_login_at'])) ?></td>
      <td class="text-end"><a class="btn btn-sm btn-outline-success" href="<?= url('admin/users/' . $user['id'] . '/edit') ?>">Edit</a></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table></div></div>
