<?php
$logFile = "log.txt";


if (isset($_POST['clear_log'])) {
    file_put_contents($logFile, ""); 
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit;
}


$date = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
$page = $_SERVER['REQUEST_URI'];

$logLine = "{$date} | IP: {$ip} | Страница: {$page}\n";
file_put_contents($logFile, $logLine, FILE_APPEND);

echo "<h2>Лог посещений (Последние 10 действий)</h2>";

if (file_exists($logFile) && filesize($logFile) > 0) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    

    $lastTenLines = array_slice($lines, -10);
    
    $lastTenLines = array_reverse($lastTenLines); 

    echo "<ul>";
    foreach ($lastTenLines as $line) {
        echo "<li>" . htmlspecialchars($line) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Лог-файл пуст.</p>";
}
?>


<form method="post">
    <button type="submit" name="clear_log">Очистить лог</button>
</form>
