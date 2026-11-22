<?php
require_once 'Person.php';
require_once 'InMemoryUserRepository.php';
require_once 'JsonFileUserRepository.php';

$jsonRepo = new JsonFileUserRepository('users.json');
$inMemoryRepo = new InMemoryUserRepository();

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $jsonRepo->delete((int)$_GET['id']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name']) && !empty($_POST['birth_date'])) {
    $person = new Person($_POST['name'], $_POST['birth_date']);
    $jsonRepo->save([
        'name' => $person->getName(),
        'age' => $person->getAge(),
        'zodiac' => $person->getZodiacSign(),
        'is_adult' => $person->isAdult()
    ]);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$pavel = new Person("Слепцов Павел", "2008-01-07");

$allUsers = $jsonRepo->findAll();

if (empty($allUsers)) {
    $pavelData = [
        'name' => $pavel->getName(),
        'age' => $pavel->getAge(),
        'zodiac' => $pavel->getZodiacSign(),
        'is_adult' => $pavel->isAdult()
    ];
    $jsonRepo->save($pavelData);

    
    $allUsers = $jsonRepo->findAll();
}

foreach ($allUsers as $user) {
    $inMemoryRepo->save($user);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вариант 16</title>
</head>
<body>
    <h2>Задание 1</h2>
    <pre><?= htmlspecialchars($pavel) ?></pre>

    <h2>Задание 2</h2>
    <h3>InMemoryUserRepository</h3>
    <pre><?php print_r($inMemoryRepo->findAll()); ?></pre>

    <h3>JsonFileUserRepository</h3>
    <pre><?php print_r($jsonRepo->findAll()); ?></pre>

    <h2>Таблица</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Возраст</th>
                <th>Знак зодиака</th>
                <th>Статус</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jsonRepo->findAll() as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['age']) ?></td>
                    <td><?= htmlspecialchars($user['zodiac']) ?></td>
                    <td><?= $user['is_adult'] ? 'Совершеннолетний' : 'Несовершеннолетний' ?></td>
                    <td><a href="?action=delete&id=<?= $user['id'] ?>">Удалить</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Добавить:</h3>
    <form method="POST" action="">
        <p>Имя: <input type="text" name="name" required></p>
        <p>Дата рождения: <input type="date" name="birth_date" required></p>
        <p><button type="submit">Добавить</button></p>
    </form>
</body>
</html>
