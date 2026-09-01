<?php
// File: controller/auth/login.php
// Author: YK
// Course: COMP 3541 - Web Programming
// Date: 2026-05-28
// Final
// Description: Controller for authenticating a user

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/UserDB.php');
$user_db = new UserDB($db);
$error = null;

// Determine action from POST or GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid request.";
    } else {
        // Rate Limiting for login
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = ['count' => 0, 'time' => time()];
        }
        if (time() - $_SESSION['login_attempts']['time'] > 300) {
            $_SESSION['login_attempts'] = ['count' => 0, 'time' => time()];
        }
        if ($_SESSION['login_attempts']['count'] >= 5) {
            $error = "For security reasons, we feel you have had too many attempts. Please wait 5 minutes and then try again. If you are having trouble signing in, email us at theartoflife07@gmail.com to replace your password. We are working on having a password reset option soon. Please stay tuned .";
        } else {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if (empty($email)) {
                $error = "Email is required.";
            } elseif (empty($password)) {
                $error = "Password is required.";
            } else {
                // Validation passed, login a user
                $user = $user_db->get_user($email);
                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['user'] = true;
                    $_SESSION['user_firstName'] = $user['firstName'];
                    $_SESSION['user_id'] = $user['userID'];
                    header('Location: ' . BASE_URL . '/index.php?action=dashboard');
                    exit();
                } else {
                    $_SESSION['login_attempts']['count']++;
                    $error = "Invalid email or password.";
                }
            }
        }
    }
}

// Render the login form (with error if set)
include($_SERVER['DOCUMENT_ROOT'] . '/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/view/login/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/view/shared/footer.php');