<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= yield_section('title') ?: config('app.name', 'XMVC Application') ?></title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            background-color: #f3f4f6;
        }
        header { background: white; padding: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        main { padding: 2rem; max-width: 800px; margin: 0 auto; }
        footer { text-align: center; padding: 1rem; color: #6b7280; font-size: 0.875rem; }
    </style>
</head>
<body>
    <header>
        <strong>XMVC</strong> Framework
        <?= view('partials.nav') ?>
    </header>
    <main>
        <?= yield_section('content') ?>
    </main>
    <footer>
        &copy; <?= date('Y') ?> XMVC Framework
    </footer>
</body>
</html>