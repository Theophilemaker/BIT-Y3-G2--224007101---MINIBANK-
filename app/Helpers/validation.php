<?php
// app/Helpers/validation.php

function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhone($phone) {
    return preg_match('/^\+?[0-9]{10,15}$/', $phone);
}

function required($fields) {
    foreach ($fields as $field) {
        if (empty($field)) return false;
    }
    return true;
}
?>