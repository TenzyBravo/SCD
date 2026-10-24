<?php
/** @var array $errors @var array $old */
$title = 'Create the administrator account';
?>
<p class="text-muted">No staff accounts exist yet. The account you create here will be the site administrator, and this page will close as soon as it is saved.</p>
<form method="post" action="<?= url('admin/setup') ?>" novalidate>
  <?= csrf() ?>
  <div class="mb-3">
    <label class="form-label" for="name">Full name</label>
    <input class="form-control<?= invalid($errors, 'name') ?>" id="name" name="name" value="<?= old($old, 'name') ?>" required/>
    <?= errorFor($errors, 'name') ?>
  </div>
  <div class="mb-3">
    <label class="form-label" for="email">Email address</label>
    <input class="form-control<?= invalid($errors, 'email') ?>" id="email" name="email" type="email" value="<?= old($old, 'email') ?>" autocomplete="username" required/>
    <?= errorFor($errors, 'email') ?>
  </div>
  <div class="mb-3">
    <label class="form-label" for="password">Password</label>
    <input class="form-control<?= invalid($errors, 'password') ?>" id="password" name="password" type="password" autocomplete="new-password" required/>
    <div class="form-text">At least 10 characters, with upper- and lowercase letters, a number and a symbol.</div>
    <?= errorFor($errors, 'password') ?>
  </div>
  <div class="mb-4">
    <label class="form-label" for="password_confirmation">Confirm password</label>
    <input class="form-control<?= invalid($errors, 'password_confirmation') ?>" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required/>
    <?= errorFor($errors, 'password_confirmation') ?>
  </div>
  <button class="btn btn-success w-100" type="submit">Create account</button>
</form>
