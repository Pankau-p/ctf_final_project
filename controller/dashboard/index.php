<?php
// File: controller/dashboard/index.php
// Author: YK
// Course: COMP 3541 - Web Programming
// Date: 2026-05-28
// Final
// Description: Dashboard controller for an authenticated user

// Check session variable, user is set, otherwise forward to login page
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/index.php?action=login');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/ctf/model/UserDB.php');
$user_db = new UserDB($db);

// Get all required data for the user
$user = $user_db->get_user_by_id($_SESSION['user_id']);
$stats = $user_db->get_user_stats($_SESSION['user_id']);
$progress = $user_db->get_progress($_SESSION['user_id']);
$challenges = $user_db->get_challenges_with_status($_SESSION['user_id']);
$leaderboard = $user_db->get_leaderboard();

// Show a leaderboard
$rank = 1;
foreach ($leaderboard as $entry) {
    if ($entry['username'] === $user['username']) break;
    $rank++;
}
$stats['rank'] = $rank;

// Render the register form (with error if set)
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/dashboard/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/footer.php');