<?php
session_start();
$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

$error = '';
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($login) || empty($password)) {
        $error = 'Заполните все поля!';
    }
    elseif (isset($users[$login]) && $users[$login]['password'] === $password) {
        $_SESSION['user'] = [
            'login' => $login,
            'email' => $users[$login]['email'] 
        ];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Неверный логин или пароль!';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }

        .error {
            color: red;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            background: #e6ffe6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        form {
            max-width: 300px;
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
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Авторизация</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['user'])): ?>
        <p class="success">Вы уже вошли как <?= htmlspecialchars($_SESSION['user']['login']) ?>. <a href="dashboard.php">В
                кабинет</a></p>
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