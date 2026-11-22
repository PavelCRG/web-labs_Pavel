<?php


function isNotEmpty($str) {
    return trim($str) !== "";
}


function checkLength($str, $min, $max) {
    $length = strlen($str);
    return $length >= $min && $length <= $max;
}


function checkEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}


function isNumber($val) {
    return is_numeric($val);
}


function checkRange($num, $min, $max) {
    return $num >= $min && $num <= $max;
}


function isInList($val, $allowedList) {
    return in_array($val, $allowedList);
}


function isComplexPassword($password) {
    if (strlen($password) < 6) {
        return false;
    }
   
    $hasDigit = preg_match('/[0-9]/', $password);
    
    $hasSpecial = preg_match('/[^A-Za-z0-9]/', $password);
    
    return $hasDigit && $hasSpecial;
}


function isValidDate($dateStr) {
    $parts = explode('-', $dateStr);
    if (count($parts) !== 3) {
        return false;
    }
    
    return checkdate($parts[1], $parts[2], $parts[0]);
}
