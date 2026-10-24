<?php
/** @var array $errors @var bool $forced */
$title = 'Change password';
?>
<div class="row justify-content-center"><div class="col-lg-6">
  <h1 class="h3 mb-3">Change your password</h1>
<?php if ($forced): ?>
  <div class="alert alert-info">You signed in with a temporary password. Choose your own password to continue.</div>
<?php endif; ?>
  <div class="card"><div class="card-body">
    <form method="post" action="<?= url('admin/password') ?>" novalidate>
      <?= csrf() ?>
      <div class="mb-3">
        <label class="form-label" for="current_password">Current password</label>
        <input class="form-control<?= invalid($errors, 'current_password') ?>" id="current_password" name="current_password" type="password" autocomplete="current-password" required/>
        <?= errorFor($errors, 'current_password') ?>
      </div>
      <div class="mb-3">
        <label class="form-label" for="password">New password</label>
        <input class="form-control<?= invalid($errors, 'password') ?>" id="password" name="password" type="password" autocomplete="new-password" required/>
        <div class="form-text">At least 10 characters, with upper- and lowercase letters, a number and a symbol.</div>
        <?= errorFor($errors, 'password') ?>
      </div>
      <div class="mb-4">
        <label class="form-label" for="password_confirmation">Confirm new password</label>
        <input class="form-control<?= invalid($errors, 'password_confirmation') ?>" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required/>
        <?= errorFor($errors, 'password_confirmation') ?>
      </div>
      <button class="btn btn-success" type="submit">Save password</button>
    </form>
  </div></div>
</div></div>
