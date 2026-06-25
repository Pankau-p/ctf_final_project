<?php 
// File: index.php
// 
// Author: YK
// Course: COMP 3541 - Web Programming
// Date: 2026-05-28
// 
// Final
//
// Description: Entry point for the app

    // Start a session
    session_start();

    if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    require_once('./config/db.php');

    // Determine action from POST or GET
    $action = $_POST['action'] ?? $_GET['action'] ?? '';


    if ($action === 'login') {
        include('controller/auth/login.php');

    } elseif ($action === 'dashboard') {
        include('controller/dashboard/index.php');

    } elseif ($action === 'logout') {
        session_destroy();
        header('Location: /ctf/index.php');
        exit();

    } elseif ($action === 'register') {
        include('controller/auth/register.php');

    } elseif ($action === 'challenge') {
        include('controller/challenge/index.php');

    } elseif ($action === 'submit_flag') {
        include('controller/challenge/index.php');

    } elseif ($action === 'about') {
        include('view/about/index.php');

    } elseif ($action === 'blog') {
        include('controller/blog/index.php');
    
    } elseif ($action === 'post') {
        include('controller/blog/post.php');

    } else { 
        include('view/shared/header.php');
        ?>
        <main class="landing">
            
            <!-- Hero - Grid background, title, buttons -->
            <div class="landing-hero">
                <div class="landing-content">
                    <h1 class="landing-title">Capture The Flag.<span class="landing-title-accent"> Start your run.</span></h1>
                    <p class="landing-subtitle">Learn real hacking skills through fun, beginner-friendly challenges. Solve puzzles, capture flags, and climb the leaderboard.</p>
                    <div class="landing-actions">
                        <a href="/ctf/index.php?action=register" class="btn btn-primary">Get Started</a>
                        <a href="/ctf/index.php?action=login" class="btn btn-outline">Login</a>
                </div>
                </div>
            </div>
        </main>

    <?php 
            include('view/shared/footer.php');
    }
?>
