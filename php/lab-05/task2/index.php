<?php

require_once 'files.php';

header("Content-Type: text/html; charset=utf-8");

echo "<h2>Работа с файлами для студента: Слепцов Павел</h2>";

$myFolder = "uploads/sleptsov_documents";
echo "1. Создание папки '$myFolder': " . (checkAndCreateDir($myFolder) ? "Успешно сделано" : "Ошибка") . "<br>";


$jsonFile = "data.json";
$studentData = [
    "first_name" => "Павел",
    "last_name"  => "Слепцов",
    "status"     => "Лабораторная работа №5 выполнена успешно"
];

writeJsonFile($jsonFile, $studentData);
echo "2. Информация о Павле сохранена в файл <b>$jsonFile</b>.<br>";


$fileData = readJsonFile($jsonFile);
echo "3. Чтение файла. Фамилия студента из JSON: <b>" . $fileData['last_name'] . "</b><br>";


$imageFile = "avatar_pavel.png";
echo "4. Расширение файла '$imageFile': " . getFileExtension($imageFile) . "<br>";
echo "5. Файл '$imageFile' это картинка (jpg/png)? " . (checkFileType($imageFile, ["jpg", "png"]) ? "Да, подходит" : "Нет") . "<br>";


$rusName = "отчет_павла_слепцова.txt";
echo "6. Английское имя для файла '$rusName': <b>" . safeFileName($rusName) . "</b><br>";
