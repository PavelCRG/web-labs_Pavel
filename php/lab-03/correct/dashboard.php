<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        .info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .logout {
            color: red;
            text-decoration: none;
        }

        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Личный кабинет</h1>
        <div class="info">
            <p><strong>Логин:</strong> <?= htmlspecialchars($user['login']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>
        <p><a href="logout.php" class="logout">Выйти из системы</a></p>
    </div>
</body>

</html>