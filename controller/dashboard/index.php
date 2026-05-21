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

include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/dashboard/index.php');
include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/footer.php');