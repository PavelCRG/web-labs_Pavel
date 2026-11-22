<?php
$data_dir = '../data/';
$filename = $data_dir . 'user_actions.log';

if (!is_dir($data_dir)) {
    mkdir($data_dir, 0777, true);
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$page = $_SERVER['REQUEST_URI'] ?? '/task4/index.php';
$date = date('Y-m-d H:i:s');
file_put_contents($filename, "[$date] IP: $ip | Page: $page" . PHP_EOL, FILE_APPEND);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear'])) {
    file_put_contents($filename, '');
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$logs = [];
if (file_exists($filename)) {
    $all_lines = array_filter(explode(PHP_EOL, file_get_contents($filename)));
    $logs = array_slice($all_lines, -10);
    $logs = array_reverse($logs);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 4</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Задание 4. Система Логгирования</h1>
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h3>Последние 10 записей лога (data/user_actions.log)</h3>
                <form method="POST" style="margin: 0;">
                    <button type="submit" name="clear" class="btn btn-danger">Очистить лог</button>
                </form>
            </div>
            <div class="console">
                <?php if (empty($logs)): ?>
                    <div style="color: #64748b; font-style: italic;">Лог-файл пуст</div>
                <?php else: ?>
                    <?php foreach ($logs as $line): ?>
                        <div class="console-line"><?= htmlspecialchars($line) ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
