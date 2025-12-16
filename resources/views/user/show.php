<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <?php if (isset($user)): ?>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($user->id); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user->name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>
</html>