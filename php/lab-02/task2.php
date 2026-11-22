<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 2. Таблица умножения</title>
    <style>
        table, td, th {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Таблица умножения</h2>

<form method="POST">
    <input type="number" style="width: 300px"; name="n" placeholder="Введите количество элементов таблицы" min="1" max="10" required>
    <button type="submit" name="table_submit">Показать</button>
</form>

<?php
// Проверяем, была ли нажата кнопка
if (isset($_POST['table_submit'])) {
    $n = $_POST['n'];

    echo "<table>";

    // Первая строка — заголовки (от * до N)
    echo "<tr>";
    echo "<th>*</th>";
    for ($i = 1; $i <= $n; $i++) {
        echo "<th>$i</th>";
    }
    echo "</tr>";

    // Остальные строки таблицы
    for ($i = 1; $i <= $n; $i++) {
        echo "<tr>";
        echo "<th>$i</th>"; // Заголовок строки слева
        for ($j = 1; $j <= $n; $j++) {
            $result = $i * $j;
            echo "<td>$result</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}
?>

</body>
</html>