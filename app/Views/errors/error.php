<?php
/** @var int $code @var string $message */
$title   = (string)$code;
$inAdmin = str_starts_with(\App\Core\Request::path(), '/admin');
?>
<section class="section"><div class="container" style="text-align:center; padding:4rem 1rem;">
  <h1><?= e($code) ?></h1>
  <p><?= e($message) ?></p>
  <p><a class="btn btn-primary" href="<?= url($inAdmin ? 'admin' : 'index.html') ?>"><?= $inAdmin ? 'Back to dashboard' : 'Go to the home page' ?></a></p>
</div></section>
