<?php
// File: controller/auth/register.php
// Author: YK
// Course: COMP 3541 - Web Programming
// Date: 2026-05-28
// Final
// Description: Controller for registering a new user

require_once($_SERVER['DOCUMENT_ROOT'] . '/ctf/model/UserDB.php');
$user_db = new UserDB($db);
$error = null;

// Determine action from POST or GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';

$username = $_POST['username'] ?? '';
$firstName = $_POST['firstName'] ?? '';
$lastName = $_POST['lastName'] ?? '';
$countryCode = $_POST['country_code'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'register') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid request.";
    } else {
        $errors = [];

        $required_fields = [  
            'username' => $username,  
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $password,
            ];

        // Validation for all fields
        foreach ($required_fields as $field=>$value) {
            if (strlen($value) < 1 || strlen($value) > 50) {
                $errors[$field] = "Required, must be less than 51 characters.";
            }
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid Email.";
        } 

        if(strlen($password) < 6 || strlen($password) > 20) {
            $errors['password'] = "Required, must be between 6 and 21 characters.";
        }

        // If validation passed, create a new user.
        if (empty($errors)) {
            $user = $user_db->register_user($username, 
                $firstName, $lastName, $countryCode,
                $email, $password);
            session_regenerate_id(true);
            $_SESSION['user'] = true;
            $_SESSION['user_firstName'] = $firstName;
            $_SESSION['user_id'] = $user;
            header('Location: /ctf/index.php?action=dashboard');
            exit();
        } else {
            $error = "Something went wrong... Try Again.";
        }
    }   
}

$countries = $user_db->get_countries();

$formData = [
    'username' => $username,
    'firstName' => $firstName,
    'lastName' => $lastName,
    'countryCode' => $countryCode,
    'email' => $email,
];

// Render the register form (with error if set)
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/register/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/footer.php');
