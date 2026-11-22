<?php
$filename = "test.txt";


echo file_get_contents($filename) . "\n";


file_put_contents($filename, "Пока!\n", FILE_APPEND);


echo file_get_contents($filename);
?>
