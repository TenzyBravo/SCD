<?php
/** @var array $errors @var array $old */
$title = 'Staff sign in';
?>
<form method="post" action="<?= url('admin/login') ?>" novalidate>
  <?= csrf() ?>
  <div class="mb-3">
    <label class="form-label" for="email">Email address</label>
    <input class="form-control<?= invalid($errors, 'email') ?>" id="email" name="email" type="email" value="<?= old($old, 'email') ?>" autocomplete="username" required autofocus/>
    <?= errorFor($errors, 'email') ?>
  </div>
  <div class="mb-4">
    <label class="form-label" for="password">Password</label>
    <input class="form-control<?= invalid($errors, 'password') ?>" id="password" name="password" type="password" autocomplete="current-password" required/>
    <?= errorFor($errors, 'password') ?>
  </div>
  <button class="btn btn-success w-100" type="submit">Sign in</button>
  <p class="text-muted small text-center mt-3 mb-0">Forgotten your password? Ask an administrator to reset it.</p>
</form>
