<?php


function readJsonFile($filename) {
    if (!file_exists($filename)) {
        return [];
    }

    $content = file_get_contents($filename);
    return json_decode($content, true);
}

function writeJsonFile($filename, $data) {
    $jsonString = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    return file_put_contents($filename, $jsonString) !== false;
}


function checkAndCreateDir($dirPath) {
    if (!is_dir($dirPath)) {
        return mkdir($dirPath, 0777, true);
    }
    return true;
}


function getFileExtension($filename) {
    return pathinfo($filename, PATHINFO_EXTENSION);
}


function checkFileType($filename, $allowedExtensions) {
    $ext = strtolower(getFileExtension($filename));
    return in_array($ext, $allowedExtensions);
}


function safeFileName($filename) {
    $letters = [
        'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё'=>'yo', 'ж'=>'zh', 
        'з'=>'z', 'и'=>'i', 'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o', 
        'п'=>'p', 'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'х'=>'h', 'ц'=>'ts', 
        'ч'=>'ch', 'ш'=>'sh', 'щ'=>'sch', 'ъ'=>'', 'ы'=>'y', 'ь'=>'', 'э'=>'e', 'ю'=>'yu', 'я'=>'ya'
    ];
    
    $filename = mb_strtolower($filename);
    return strtr($filename, $letters);
}
