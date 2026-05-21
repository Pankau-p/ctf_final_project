<?php
// File: controller/auth/login.php
// Author: 
// Course: COMP 3541 - Web Programming
// Date: 2026-05-19
// Final
// Description: Controller for authenticating a user

require_once($_SERVER['DOCUMENT_ROOT'] . '/ctf/model/UserDB.php');
$user_db = new UserDB($db);
$error = null;

// Determine action from POST or GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($email)) {
        $error = "Email is required.";
    } elseif (empty($password)) {
        $error = "Password is required.";
    } else {
        $user = $user_db->get_user($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = true;
            $_SESSION['user_firstName'] = $user['firstName'];
            $_SESSION['user_id'] = $user['userID'];
            header('Location: /ctf/index.php?action=dashboard');
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}

// Render the login form (with error if set)
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/login/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/footer.php');