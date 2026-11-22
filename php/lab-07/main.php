<?php
session_start();

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Models\OrderService;
use App\Repositories\InMemoryUserRepository;
use App\Repositories\JsonFileUserRepository;

if (!isset($_SESSION['logs'])) $_SESSION['logs'] = [];
if (!isset($_SESSION['memory_users'])) $_SESSION['memory_users'] = [];

$orderService = new OrderService();
foreach ($_SESSION['logs'] as $log) {
    $orderService->log(preg_replace('/^\[.*?\]\s/', '', $log));
}

$inMemoryRepo = new InMemoryUserRepository();
foreach ($_SESSION['memory_users'] as $u) {
    $inMemoryRepo->save($u);
}

$jsonRepo = new JsonFileUserRepository(__DIR__ . '/users.json');

$message = '';
$outputData = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'create_order') {
            $orderId = (int)($_POST['order_id'] ?? 0);
            $amount = (float)($_POST['amount'] ?? 0);
            $message = $orderService->processOrder($orderId, $amount);
            $_SESSION['logs'] = $orderService->getLogs();
        } 
        elseif ($action === 'show_logs') {
            $outputData = $orderService->getLogs();
        } 
        elseif ($action === 'add_memory') {
            $id = (int)($_POST['user_id'] ?? 0);
            $name = trim($_POST['user_name'] ?? '');
            $inMemoryRepo->save(['id' => $id, 'name' => $name]);
            $_SESSION['memory_users'] = $inMemoryRepo->findAll();
            $message = "Успешно сохранено в память";
        } 
        elseif ($action === 'show_memory') {
            $outputData = $inMemoryRepo->findAll();
        } 
        elseif ($action === 'add_json') {
            $id = (int)($_POST['user_id'] ?? 0);
            $name = trim($_POST['user_name'] ?? '');
            $jsonRepo->save(['id' => $id, 'name' => $name]);
            $message = "Успешно сохранено в JSON";
        } 
        elseif ($action === 'show_json') {
            $outputData = $jsonRepo->findAll();
        } 
        elseif ($action === 'clear') {
            $_SESSION['logs'] = [];
            $_SESSION['memory_users'] = [];
            if (file_exists(__DIR__ . '/users.json')) {
                unlink(__DIR__ . '/users.json');
            }
            header("Location: main.php");
            exit;
        }
    } catch (\InvalidArgumentException $e) {
        $message = "Ошибка: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная 7</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 20px auto; padding: 0 10px; }
        form { margin: 10px 0; }
        input { margin-right: 5px; padding: 4px; }
        button { padding: 4px 10px; cursor: pointer; }
        pre { background: #eee; padding: 10px; overflow-x: auto; }
        .msg { color: green; font-weight: bold; margin: 10px 0; }
    </style>
</head>
<body>

    <h2>Лабораторная работа 7 (Вариант 16)</h2>
    
    <?php if ($message): ?>
        <div class="msg"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <h3>1. Заказы (OrderService)</h3>
    <form method="POST">
        <input type="hidden" name="action" value="create_order">
        <input type="number" name="order_id" placeholder="ID заказа" required>
        <input type="text" name="amount" placeholder="Сумма" required>
        <button type="submit">Создать заказ</button>
    </form>
    <form method="POST">
        <input type="hidden" name="action" value="show_logs">
        <button type="submit">Показать логи</button>
    </form>

    <hr>

    <h3>2. В памяти (InMemoryUserRepository)</h3>
    <form method="POST">
        <input type="hidden" name="action" value="add_memory">
        <input type="number" name="user_id" placeholder="ID" required>
        <input type="text" name="user_name" placeholder="Имя" required>
        <button type="submit">Добавить</button>
    </form>
    <form method="POST">
        <input type="hidden" name="action" value="show_memory">
        <button type="submit">Показать из памяти</button>
    </form>

    <hr>

    <h3>3. В файле (JsonFileUserRepository)</h3>
    <form method="POST">
        <input type="hidden" name="action" value="add_json">
        <input type="number" name="user_id" placeholder="ID" required>
        <input type="text" name="user_name" placeholder="Имя" required>
        <button type="submit">Добавить</button>
    </form>
    <form method="POST">
        <input type="hidden" name="action" value="show_json">
        <button type="submit">Показать из JSON</button>
    </form>

    <hr>

    <form method="POST">
        <input type="hidden" name="action" value="clear">
        <button type="submit" style="color: red;">Сбросить всё</button>
    </form>

    <?php if ($outputData !== null): ?>
        <h3>Результат:</h3>
        <pre><?= htmlspecialchars(print_r($outputData, true)) ?></pre>
    <?php endif; ?>

</body>
</html>
