<?php
// File: controller/challenge/index.php
// Author: YK
// Course: COMP 3541 - Web Programming
// Date: 2026-05-28
// Final
// Description: Challenge controller for an authenticated user

// Check session variable, user is set, otherwise forward to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/index.php?action=login');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/ctf/model/UserDB.php');
$user_db = new UserDB($db);
$error = null;

// Determine action from POST or GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';

$challenge_id = $_GET['id'] ?? null;

// User submits a flag
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'submit_flag') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error = "Invalid request.";
    } else {
    
        $challengeID = $_POST['challengeID'] ?? null;
        $flag = $_POST['flag'];
        $user_id = $_SESSION['user_id'];
        $challenge = $user_db->get_challenge($challengeID, $user_id);

        // Rate limiting
        $attempt_key = 'attempts_' . $challengeID;
        if (!isset($_SESSION[$attempt_key])) {
            $_SESSION[$attempt_key] = ['count' => 0, 'time' => time()];
        }

        // Reset count if 5 minutes have passed
        if (time() - $_SESSION[$attempt_key]['time'] > 300) {
            $_SESSION[$attempt_key] = ['count' => 0, 'time' => time()];
        }

        // Block if over 10 attempts
        if ($_SESSION[$attempt_key]['count'] >= 10) {
            $error = "Too many attempts. Please wait 5 minutes.";
        } else {
            $challenge = $user_db->get_challenge($challengeID, $user_id);
            if (hash_equals($challenge['flag'], $flag)) {
                $user_db->submit_flag($user_id, $challengeID);
                $challenge = $user_db->get_challenge($challengeID, $user_id);
                $success = "Flag accepted! Well done.";
            } else {
                $_SESSION[$attempt_key]['count']++;
                $error = "Invalid Flag, try again!";
            }
        }
    }
        // Show a challenge page based on challenge ID
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'challenge') {
        $challenge_id = $_GET['id'] ?? null;
        $user_id = $_SESSION['user_id'];
        $user = $user_db->get_user_by_id($user_id);
        $challenge = $user_db->get_challenge($challenge_id, $user_id);

        // CTF FLAG for use in challenge 1005
        if ($challenge['challengeID'] == 1005) {
        header('X-Secret-Flag: CTF{headers_carry_secrets}');
        }

        // CTF FlAG for use in challenge 1004
        if ($challenge_id == 1004) {
            setcookie('flag', 'CTF{cookies_are_not_secret}', time() + 3600);
        }
    }


// Render the register form (with error if set)
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/challenge/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/footer.php');