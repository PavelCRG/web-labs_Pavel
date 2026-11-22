<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 4. Поиск в массиве</title>
</head>
<body>

<h2>Поиск товара</h2>

<?php
// 1. Создаём ассоциативный массив товаров: название => цена
$products = array(
    "Хлеб" => 2.5,
    "Молоко" => 3.2,
    "Масло" => 5.8,
    "Сыр" => 8.9,
    "Яйца" => 4.1
);

// 2. Выводим все товары в виде списка
echo "<h3>Список товаров:</h3>";
echo "<ul>";
foreach ($products as $name => $price) {
    echo "<li>$name - $price руб.</li>";
}
echo "</ul>";
?>

<!-- Форма поиска товара -->
<form method="POST">
    <input type="text" style="width: 250px";  name="product_name" placeholder="Введите навазние товара:" required>
    <button type="submit" name="search_submit">Найти</button>
</form>

<?php
// 3. Пользователь вводит название товара, ищем его
if (isset($_POST['search_submit'])) {
    $search = $_POST['product_name'];
    $found = false;

    // Проходим по всем товарам
    foreach ($products as $name => $price) {
        if ($name == $search) {
            echo "<h3>Товар '$name' найден! Цена: $price руб.</h3>";
            $found = true;
            break;
        }
    }

    // 4. Если товар не найден — выводим сообщение
    if ($found == false) {
        echo "<h3 style='color:red;'>Товар не найден</h3>";
    }
}
?>

</body>
</html>