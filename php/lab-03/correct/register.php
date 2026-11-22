<?php
session_start();
$usersFile = 'users.json';

$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$errors = [];
$success = false;
$login = trim($_POST['login'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Валидация логина
    if (empty($login)) {
        $errors[] = 'Логин обязателен!';
    } elseif (strlen($login) < 3) {
        $errors[] = 'Логин должен содержать минимум 3 символа!';
    } elseif (isset($_SESSION['users'][$login])) {
        $errors[] = 'Пользователь с таким логином уже существует!';
    }

    // Валидация пароля
    if (empty($password)) {
        $errors[] = 'Пароль обязателен!';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Пароль должен содержать минимум 6 символов!';
    } elseif ($password !== $confirm) {
        $errors[] = 'Пароли не совпадают!';
    }

    // Валидация email
    if (empty($email)) {
        $errors[] = 'Email обязателен!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный формат email!';
    }
    
    // Проверка на существование пользователя теперь идет по массиву $users
    if (isset($users[$login])) {
        $errors[] = 'Пользователь с таким логином уже существует!';
    }

    // Сохранение при отсутствии ошибок
    if (empty($errors)) {
        $users[$login] = [
            'password' => $password, 
            'email' => $email,
            'registered_at' => date('Y-m-d H:i:s')
        ];
        // Записываем обновленный массив обратно в файл
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $success = true;
    }
}
?>
<!-- HTML часть остается без изменений -->
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <style>
        .error {
            color: red;
        }

        .success {
            color: green;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1e7e34;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Регистрация</h1>

    <?php if (!empty($errors)): ?>
        <ul class="error">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success" style="text-align: center;">Регистрация успешна! <a href="login.php">Войти</a></p>
    <?php else: ?>
        <form method="POST">
            <label>Логин (мин. 3 символа):</label>
            <input type="text" name="login" value="<?= htmlspecialchars($login) ?>" required>

            <label>Пароль (мин. 6 символов):</label>
            <input type="password" name="password" required>

            <label>Подтверждение пароля:</label>
            <input type="password" name="confirm" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

            <button type="submit">Зарегистрироваться</button>
        </form>
    <?php endif; ?>
</body>

</html>