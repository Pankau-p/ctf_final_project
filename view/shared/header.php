<!--

File: view/shared/header/index.php

Author: YK
Course: COMP 3541 - Web Programming
Date: 2026-05-28

Final

Description: View for the header
-->
<?php $action = $_GET['action'] ?? ''; 
$page_title = $page_title ?? 'OutRun CTF — CTF Training Platform';
$page_description = $page_description ?? 'Learn real hacking skills through fun, beginner-friendly challenges. Solve puzzles, capture flags, and climb the leaderboard.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
    <meta property="og:type" content="website">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link rel="icon" type="image/x-icon" href="/ctf/favicon.ico">
    <link rel="stylesheet" href="/ctf/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
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
            <a href="/blog" 
                class="<?= $action === 'blog' || $action === 'post' ? 'active' : '' ?>">
                Resources</a>
            <a href="/ctf/index.php?action=about"
                class="<?= $action === 'about' ? 'active' : '' ?>">
                About</a>
            <a href="/ctf/index.php?action=logout">Logout</a>

        <?php else: ?>
            <a href="/blog" class="<?= $action === 'blog' || $action === 'post' ? 'active' : '' ?>">Resources</a>
            <a href="/ctf/index.php?action=about">About</a>
            <a href="/ctf/index.php?action=login">Login</a>
            <a href="/ctf/index.php?action=register" class="btn btn-primary">Sign Up</a>

        <?php endif; ?>
    </nav>
</header>