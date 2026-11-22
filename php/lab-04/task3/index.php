<?php
$filename = "student.csv";


$newStudentLine = "Хилько Иван Владимирович,41 ИБ,9.5\n";
file_put_contents($filename, $newStudentLine, FILE_APPEND);


echo '<table border="1">';
$file = fopen($filename, "r");

while (($row = fgetcsv($file)) !== false) {
    
    if (empty($row) || !isset($row[1])) {
        continue;
    }

    echo "<tr>
            <td>{$row[0]}</td>
            <td>{$row[1]}</td>
            <td>{$row[2]}</td>
          </tr>";
}
fclose($file);
echo '</table>';
?>
