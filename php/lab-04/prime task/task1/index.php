<?php
$data_dir = '../data/';
$filename = $data_dir . 'test.txt';

if (!is_dir($data_dir)) {
    mkdir($data_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $initial_text = "Студент: Хожевец Никита Олегович\nГруппа: 41 ИБ\nСредний балл: 9.5\nСтудент: Слепцов Павел Леонидович\nГруппа: 41 ИБ\nСредний балл: 9.3\n";
        file_put_contents($filename, $initial_text);
    } elseif (isset($_POST['append'])) {
        $text = trim(htmlspecialchars($_POST['text']));
        if (!empty($text)) {
            file_put_contents($filename, $text . "\n", FILE_APPEND);
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$content = file_exists($filename) ? htmlspecialchars(file_get_contents($filename)) : 'Файл еще не создан в папке data/';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 1</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Задание 1. Работа с текстовым файлом</h1>
        <div class="card">
            <form method="POST">
                <button type="submit" name="create" class="btn">Создать файл test.txt с вашими данными</button>
            </form>
            <form method="POST">
                <input type="text" name="text" required placeholder="Введите новую строку...">
                <button type="submit" name="append" class="btn">Добавить строку</button>
            </form>
            <h3>Содержимое файла:</h3>
            <pre style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-top: 10px; white-space: pre-wrap;"><?= $content ?></pre>
        </div>
    </div>
</body>
</html>
