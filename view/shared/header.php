<!--

File: view/shared/header/index.php

Author: YK
Course: COMP 3541 - Web Programming
Date: 2026-05-28

Final

Description: View for the header
-->
<?php $action = $_GET['action'] ?? ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OutRun CTF</title>
    <link rel="stylesheet" href="/ctf/main.css">
</head>
<body>

<!-- Left Side -->
<header class="header">
    <a href="/ctf/index.php" class="header-brand">
        <div class="header-logo-text">
            <span class="header-logo-name">OutRun<span class="header-logo-ctf">CTF</span></span>
            <span class="header-logo-tagline">CTF Training Platform</span>
        </div>
    </a>

    <!-- Nav Buttons -->
    <nav class="header-nav">

        <?php if (isset($_SESSION['user'])): ?>

            <a href="/ctf/index.php?action=dashboard"
                class="<?= $action === 'dashboard' ? 'active' : '' ?>">
                Dashboard
            </a>
            <a href="/ctf/index.php?action=about"
                class="<?= $action === 'about' ? 'active' : '' ?>">
                About</a>
            <a href="/ctf/index.php?action=logout">Logout</a>

        <?php else: ?>
            <a href="/ctf/index.php?action=about">About</a>
            <a href="/ctf/index.php?action=login">Login</a>
            <a href="/ctf/index.php?action=register" class="btn btn-primary">Sign Up</a>

        <?php endif; ?>
    </nav>
</header>