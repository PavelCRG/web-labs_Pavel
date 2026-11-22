<?php
$data_dir = '../data/';
$filename = $data_dir . 'students.csv';

if (!is_dir($data_dir)) {
    mkdir($data_dir, 0777, true);
}

if (!file_exists($filename)) {
    $fp = fopen($filename, 'w');
    fputcsv($fp, ['ФИО', 'Группа', 'Средний балл']);
    fputcsv($fp, ['Хожевец Никита Олегович', '41 ИБ', '9.5']);
    fputcsv($fp, ['Слепцов Павел Леонидович', '41 ИБ', '9.3']);
    fclose($fp);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $fio = trim(htmlspecialchars($_POST['fio']));
    $group = trim(htmlspecialchars($_POST['group']));
    $gpa = trim(htmlspecialchars($_POST['gpa']));
    
    if (!empty($fio) && !empty($group) && !empty($gpa)) {
        $fp = fopen($filename, 'a');
        fputcsv($fp, [$fio, $group, $gpa]);
        fclose($fp);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$students = [];
if (($fp = fopen($filename, 'r')) !== false) {
    $headers = fgetcsv($fp);
    while (($row = fgetcsv($fp)) !== false) {
        $students[] = $row;
    }
    fclose($fp);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание 3</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Задание 3. Работа с CSV файлом</h1>
        <div class="card">
            <h3>Добавить нового студента</h3>
            <form method="POST" style="flex-direction: column;">
                <input type="text" name="fio" required placeholder="ФИО студента">
                <input type="text" name="group" required placeholder="Группа (например, 41 ИБ)">
                <input type="number" name="gpa" step="0.1" min="0" max="10" required placeholder="Средний балл">
                <button type="submit" name="add" class="btn">Добавить в CSV</button>
            </form>
        </div>
        <div class="card">
            <h3>Список студентов из файла (data/students.csv)</h3>
            <table>
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Группа</th>
                        <th>Средний балл</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= $student[0] ?></td>
                            <td><?= $student[1] ?></td>
                            <td><span style="background: #e0e7ff; color: #4338ca; padding: 4px 8px; border-radius: 6px; font-weight: bold;"><?= $student[2] ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
