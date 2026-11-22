<?php

$users = [
    'admin' => 'admin123',
    'user' => 'password',
    'ivan' => 'qwerty'
];

$error = '';
$success = '';
$login = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    
    if (empty($login) || empty($password)) {
        $error = "Заполните все поля!";
    } elseif (isset($users[$login]) && $users[$login] === $password) {
        $success = "Добро пожаловать, $login!";
    } else {
        $error = "Неверный логин или пароль!";
    }
}
?>
<!DOCTYPE DOCUMENT html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <style>
        .success { color: green; background: #e0ffe0; padding: 10px; border-radius: 5px; }
        .error { color: red; background: #ffe0e0; padding: 10px; border-radius: 5px; }
        form { max-width: 300px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        input { width: 100%; padding: 8px; margin: 5px 0 15px 0; box-sizing: border-box; border-radius: 3px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Авторизация</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
        <p style="text-align: center;"><a href="login.php">Войти еще раз</a></p>
    <?php else: ?>
        <form method="POST">
            <label>Логин:</label>
            <input type="text" name="login" value="<?= htmlspecialchars($login) ?>" required>

            <label>Пароль:</label>
            <input type="password" name="password" required>

            <button type="submit">Войти</button>
        </form>
    <?php endif; ?>
</body>
</html>