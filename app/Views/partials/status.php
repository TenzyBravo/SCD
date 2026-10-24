<?php /** @var string $status */ ?>
<span class="badge text-bg-<?= $status === 'published' ? 'success' : 'secondary' ?>"><?= $status === 'published' ? 'Published' : 'Draft' ?></span>
