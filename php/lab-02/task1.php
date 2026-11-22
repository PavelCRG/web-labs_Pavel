<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 1. Калькулятор</title>
</head>
<body>

<h2>Мини-калькулятор</h2>

<form method="POST">
    <input type="number" step="any" name="num1" placeholder="Введите 1 число" required>
    <select name="operation">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>
    <input type="number" step="any" name="num2" placeholder="Введите 2 число" required>
    <button type="submit" name="calc_submit">Рассчитать</button>
</form>

<?php
// Проверяем, была ли нажата кнопка
if (isset($_POST['calc_submit'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];
    $result = 0;
    $error = "";

    // Выполняем действие в зависимости от выбранной операции
    switch ($operation) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            $result = $num1 - $num2;
            break;
        case '*':
            $result = $num1 * $num2;
            break;
        case '/':
            if ($num2 == 0) {
                $error = "Ошибка: Деление на ноль!";
            } else {
                $result = $num1 / $num2;
            }
            break;
    }

    // Выводим результат или ошибку
    if ($error != "") {
        echo "<h3 style='color:red;'>$error</h3>";
    } else {
        echo "<h3>Результат = $result</h3>";
    }
}
?>

</body>
</html>