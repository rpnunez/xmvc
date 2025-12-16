<?php extend('layouts.app'); ?>

<?php section('title'); ?>
Welcome - XMVC
<?php endsection(); ?>

<?php section('content'); ?>
<div style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); text-align: center;">
    <h1>Welcome to XMVC</h1>
    <p>Hello, <strong><?= htmlspecialchars($name) ?></strong>!</p>
    <p>This view now uses the new and improved layout system!</p>
</div>
<?php endsection(); ?>