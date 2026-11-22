<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 3. Массивы</title>
</head>
<body>

<h2>Массив чисел</h2>

<?php
// 1. Создаём массив из 10 случайных чисел от 1 до 100
$numbers = array();
for ($i = 0; $i < 10; $i++) {
    $numbers[] = rand(1, 100);
}

// 2. Выводим все числа в виде списка
echo "<h3>Массив чисел</h3>";
echo "<pre>";
echo "Array\n(\n";
foreach ($numbers as $key => $value) {
    echo "    [$key] => $value\n";
}
echo ")";
echo "</pre>";

// 3. Сумма всех чисел
$sum = 0;
foreach ($numbers as $value) {
    $sum = $sum + $value;
}
echo "<p>Сумма: <b>$sum</b></p>";

// 4. Среднее арифметическое
$average = $sum / count($numbers);
echo "<p>Среднее: <b>$average</b></p>";

// 5. Минимальное и максимальное число
$min = $numbers[0];
$max = $numbers[0];
foreach ($numbers as $value) {
    if ($value < $min) {
        $min = $value;
    }
    if ($value > $max) {
        $max = $value;
    }
}
echo "<p>Минимальное: <b>$min</b>, Максимальное: <b>$max</b></p>";

// 6. Все чётные числа
$evens = array();
foreach ($numbers as $value) {
    if ($value % 2 == 0) {
        $evens[] = $value;
    }
}

echo "<p>Четные числа: <b>";
foreach ($evens as $value) {
    echo "$value ";
}
echo "</b></p>";
?>

</body>
</html>