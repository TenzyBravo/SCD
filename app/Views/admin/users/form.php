<?php
/** @var array|null $user @var array $roles @var array $errors @var array $old */
$title = $user ? 'Edit staff member' : 'Add staff member';
$val   = static fn(string $k, $d = '') => $old[$k] ?? ($user[$k] ?? $d);
?>
<h1 class="h3 mb-3"><?= e($title) ?></h1>
<div class="card"><div class="card-body">
<form method="post" action="<?= url($user ? 'admin/users/' . $user['id'] : 'admin/users') ?>" novalidate autocomplete="off">
  <?= csrf() ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label" for="name">Full name</label>
      <input class="form-control<?= invalid($errors, 'name') ?>" id="name" name="name" maxlength="120" value="<?= e($val('name')) ?>" required/>
      <?= errorFor($errors, 'name') ?>
    </div>
    <div class="col-md-6">
      <label class="form-label" for="email">Email address</label>
      <input class="form-control<?= invalid($errors, 'email') ?>" id="email" name="email" type="email" maxlength="190" value="<?= e($val('email')) ?>" required/>
      <?= errorFor($errors, 'email') ?>
    </div>
    <div class="col-md-6">
      <label class="form-label" for="role_id">Role</label>
      <select class="form-select<?= invalid($errors, 'role_id') ?>" id="role_id" name="role_id">
<?php foreach ($roles as $role): ?>
        <option value="<?= (int)$role['id'] ?>"<?= (string)$val('role_id') === (string)$role['id'] ? ' selected' : '' ?>><?= e($role['name']) ?> — <?= e($role['description']) ?></option>
<?php endforeach; ?>
      </select>
      <?= errorFor($errors, 'role_id') ?>
    </div>
<?php if ($user): ?>
    <div class="col-md-6">
      <label class="form-label" for="status">Status</label>
      <select class="form-select<?= invalid($errors, 'status') ?>" id="status" name="status">
        <option value="active"<?= $val('status') === 'active' ? ' selected' : '' ?>>Active — can sign in</option>
        <option value="suspended"<?= $val('status') === 'suspended' ? ' selected' : '' ?>>Suspended — cannot sign in</option>
      </select>
      <?= errorFor($errors, 'status') ?>
    </div>
<?php endif; ?>
    <div class="col-md-6">
      <label class="form-label" for="password"><?= $user ? 'Reset password' : 'Temporary password' ?></label>
      <input class="form-control<?= invalid($errors, 'password') ?>" id="password" name="password" type="text" autocomplete="new-password"<?= $user ? '' : ' required' ?>/>
      <div class="form-text"><?= $user ? 'Leave empty to keep their current password. ' : '' ?>At least 10 characters with upper- and lowercase letters, a number and a symbol. Share it with them privately — they must change it when they first sign in.</div>
      <?= errorFor($errors, 'password') ?>
    </div>
  </div>
  <div class="mt-4 d-flex gap-2">
    <button class="btn btn-success" type="submit">Save</button>
    <a class="btn btn-outline-secondary" href="<?= url('admin/users') ?>">Cancel</a>
  </div>
</form>
</div></div>
