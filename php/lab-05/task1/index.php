<?php

require_once 'validate.php';

header("Content-Type: text/html; charset=utf-8");

echo "<h2>Проверка валидации для студента: Слепцов Павел</h2>";

echo "1. Текст не пустой: " . (isNotEmpty("Слепцов Павел") ? "Да" : "Нет") . "<br>";
echo "2. Длина имени 'Павел' от 3 до 10 букв: " . (checkLength("Павел", 3, 10) ? "Да" : "Нет") . "<br>";
echo "3. Почта 'pavel@local.ru' правильная: " . (checkEmail("pavel@local.ru") ? "Да" : "Нет") . "<br>";
echo "4. Текст '125' это число: " . (isNumber("125") ? "Да" : "Нет") . "<br>";
echo "5. Число 34 входит в рамки от 10 до 50: " . (checkRange(34, 10, 50) ? "Да" : "Нет") . "<br>";
echo "6. Роль 'student' есть в списке: " . (isInList("student", ["user", "student"]) ? "Да" : "Нет") . "<br>";
echo "7. Пароль 'Pavel123!' достаточно сложный: " . (isComplexPassword("Pavel123!") ? "Да" : "Нет") . "<br>";
echo "8. Дата '2026-10-10' настоящая: " . (isValidDate("2026-10-10") ? "Да" : "Нет") . "<br>";
