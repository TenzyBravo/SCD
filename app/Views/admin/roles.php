<?php
/** @var array $roles @var array $permissions @var array $matrix */
$title = 'Roles';
?>
<h1 class="h3 mb-1">Roles &amp; permissions</h1>
<p class="text-muted">Tick what each role may do. Every staff member has one role. The Administrator role always has every permission.</p>
<form method="post" action="<?= url('admin/roles') ?>">
  <?= csrf() ?>
  <div class="card mb-3"><div class="table-responsive"><table class="table mb-0 perm-matrix">
    <thead><tr><th>Permission</th>
<?php foreach ($roles as $role): ?>
      <th><?= e($role['name']) ?><div class="small text-muted fw-normal"><?= (int)$role['user_count'] ?> staff</div></th>
<?php endforeach; ?>
    </tr></thead>
    <tbody>
<?php foreach ($permissions as $perm): ?>
      <tr>
        <td><?= e($perm['name']) ?></td>
<?php foreach ($roles as $role): $rid = (int)$role['id']; $pid = (int)$perm['id']; $isAdmin = $role['slug'] === 'admin'; ?>
        <td><input class="form-check-input" type="checkbox" name="perm[<?= $rid ?>][]" value="<?= $pid ?>" aria-label="<?= e($role['name'] . ': ' . $perm['name']) ?>"<?= ($isAdmin || isset($matrix[$rid][$pid])) ? ' checked' : '' ?><?= $isAdmin ? ' disabled' : '' ?>/></td>
<?php endforeach; ?>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table></div></div>
  <button class="btn btn-success" type="submit">Save permissions</button>
</form>
