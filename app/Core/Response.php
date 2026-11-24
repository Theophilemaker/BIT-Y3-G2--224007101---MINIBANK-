<?php
// app/Core/Response.php

class Response {
    public static function redirect($path) {
        if (headers_sent()) {
            echo "<script>window.location.href='" . BASE_URL . $path . "';</script>";
            exit;
        }
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    public static function withMessage($path, $type, $message) {
        $_SESSION[$type] = $message;
        self::redirect($path);
    }
}