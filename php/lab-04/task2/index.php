<?php
$filename = "test.txt";
$searchWord = "Привет.";

$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$totalLines = count($lines);


foreach ($lines as $index => $line) {
    $lineNumber = $index + 1;
    echo "Строка {$lineNumber}: {$line}\n";
    
    
    if (str_contains($line, $searchWord)) {
        echo "   [Найдено слово '{$searchWord}' в строке {$lineNumber}]\n";
    }
}


echo "\nВсего строк в файле: {$totalLines}\n";
?>
