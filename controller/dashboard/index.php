<?php
// File: controller/dashboard/index.php
// Author: 
// Course: COMP 3541 - Web Programming
// Date: 2026-05-19
// Final
// Description: Dashboard controller for an authenticated user

if (!isset($_SESSION['user'])) {
    header('Location: /ctf/index.php?action=login');
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/ctf/model/UserDB.php');
$user_db = new UserDB($db);

$user = $user_db->get_user_by_id($_SESSION['user_id']);
$stats = $user_db->get_user_stats($_SESSION['user_id']);
$progress = $user_db->get_progress($_SESSION['user_id']);
$challenges = $user_db->get_challenges_with_status($_SESSION['user_id']);
$leaderboard = $user_db->get_leaderboard();

$rank = 1;
foreach ($leaderboard as $entry) {
    if ($entry['username'] === $user['username']) break;
    $rank++;
}
$stats['rank'] = $rank;

include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/dashboard/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/footer.php');