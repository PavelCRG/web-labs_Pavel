<?php
$filename = '../data/test.txt';
$lines = [];
$search_results = [];
$search_word = $_GET['search'] ?? '';

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!empty($search_word)) {
        foreach ($lines as $index => $line) {
            if (mb_stripos($line, $search_word) !== false) {
                $search_results[] = ['num' => $index + 1, 'text' => $line];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 2</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Задание 2. Построчное чтение файла</h1>
        <div class="card">
            <p><strong>Всего строк в файле:</strong> <?= count($lines) ?></p>
            <table>
                <thead>
                    <tr>
                        <th style="width: 100px;">№ Строки</th>
                        <th>Текст</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lines as $index => $line): ?>
                        <tr>
                            <td><strong><?= $index + 1 ?></strong></td>
                            <td><?= htmlspecialchars($line) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card">
            <h3>Поиск строки с определенным словом (например, Хожевец или Слепцов)</h3>
            <form method="GET">
                <input type="text" name="search" value="<?= htmlspecialchars($search_word) ?>" placeholder="Введите фамилию или группу...">
                <button type="submit" class="btn">Найти</button>
            </form>
            <?php if (!empty($search_word)): ?>
                <h4>Результаты поиска:</h4>
                <ul>
                    <?php foreach ($search_results as $res): ?>
                        <li style="margin: 8px 0;">Строка <strong><?= $res['num'] ?></strong>: <?= htmlspecialchars($res['text']) ?></li>
                    <?php endforeach; ?>
                    <?php if (empty($search_results)): ?>
                        <li>Ничего не найдено</li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
