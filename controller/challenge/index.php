<?php
// File: controller/challenge/index.php
// Author: 
// Course: COMP 3541 - Web Programming
// Date: 2026-05-19
// Final
// Description: Challenge controller for an authenticated user

if (!isset($_SESSION['user_id'])) {
    header('Location: /ctf/index.php?action=login');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/ctf/model/UserDB.php');
$user_db = new UserDB($db);
$error = null;

// Determine action from POST or GET
$action = $_POST['action'] ?? $_GET['action'] ?? '';

$challenge_id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'submit_flag') {
    $challengeID = $_POST['challengeID'] ?? null;
    $flag = $_POST['flag'];
    $user_id = $_SESSION['user_id'];
    $challenge = $user_db->get_challenge($challengeID, $user_id);

    if ($flag === $challenge['flag']) {
        $user_db->submit_flag($user_id, $challengeID);
        $challenge = $user_db->get_challenge($challengeID, $user_id);
        $success =  "Flag accepted! Well done.";
    } else {
        $error = "Invalid Flag, try again!";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'challenge') {
    $challenge_id = $_GET['id'] ?? null;
    $user_id = $_SESSION['user_id'];
    $user = $user_db->get_user_by_id($user_id);
    $challenge = $user_db->get_challenge($challenge_id, $user_id);

    if ($challenge_id == 1004) {
        setcookie('flag', 'CTF{cookies_are_not_secret}', time() + 3600);
    }
}

include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/challenge/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/footer.php');