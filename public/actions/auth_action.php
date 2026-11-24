<?php
// public/actions/auth_action.php
require_once '../../app/Config/config.php';
require_once '../../app/Models/User.php';
require_once '../../app/Core/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRF($_POST['csrf_token'] ?? '')) {
        die("CSRF Token Validation Failed.");
    }

    $action = $_POST['action'] ?? '';
    $userModel = new User();

    if ($action === 'login') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $user = $userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['status'] !== 'active') die("Account suspended.");
            
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];

            if ($user['role'] === 'admin') {
                header('Location: ' . BASE_URL . 'admin/dashboard.php');
            } else {
                header('Location: ' . BASE_URL . 'customer/dashboard.php');
            }
            exit;
        } else {
            $_SESSION['error'] = "Invalid credentials.";
            header('Location: ' . BASE_URL . 'login.php');
            exit;
        }
    }

    if ($action === 'register') {
        $data = [
            'first_name' => htmlspecialchars($_POST['first_name']),
            'last_name' => htmlspecialchars($_POST['last_name']),
            'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
            'phone' => htmlspecialchars($_POST['phone']),
            'address' => htmlspecialchars($_POST['address']),
            'password' => $_POST['password']
        ];

        if ($userModel->register($data)) {
            $_SESSION['success'] = "Registration successful. Please login.";
            header('Location: ' . BASE_URL . 'login.php');
        } else {
            $_SESSION['error'] = "Registration failed. Email may already exist.";
            header('Location: ' . BASE_URL . 'register.php');
        }
        exit;
    }
}
?>