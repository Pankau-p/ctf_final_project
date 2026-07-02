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
        $page_title = 'OutRun CTF — CTF Training Platform';
        $page_description = 'Learn real hacking skills through fun, beginner-friendly challenges. Solve puzzles, capture flags, and climb the leaderboard.';
        include('view/shared/header.php');
        ?>
       <main class="landing">
            <div class="landing-hero">

                <svg class="landing-grid" viewBox="0 0 1200 500" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="0" y1="450" x2="1200" y2="450" stroke="#ff2d6b" stroke-width="1.2" opacity="0.5"/>
                    <line x1="0" y1="390" x2="1200" y2="390" stroke="#7c3aed" stroke-width="0.8" opacity="0.4"/>
                    <line x1="0" y1="338" x2="1200" y2="338" stroke="#7c3aed" stroke-width="0.6" opacity="0.32"/>
                    <line x1="0" y1="293" x2="1200" y2="293" stroke="#7c3aed" stroke-width="0.5" opacity="0.25"/>
                    <line x1="0" y1="254" x2="1200" y2="254" stroke="#7c3aed" stroke-width="0.4" opacity="0.18"/>
                    <line x1="0" y1="220" x2="1200" y2="220" stroke="#7c3aed" stroke-width="0.3" opacity="0.13"/>
                </svg>

                <div class="landing-content">
                    <span class="landing-tag">CTF Training Platform</span>
                    <h1 class="landing-title">Capture The Flag.<br><span class="landing-title-accent">Start your run.</span></h1>
                    <p class="landing-subtitle">Learn real hacking skills through fun, beginner-friendly challenges. Solve puzzles, capture flags, and climb the leaderboard.</p>
                    <div class="landing-actions">
                        <a href="/ctf/index.php?action=register" class="btn btn-hero-primary">Get Started</a>
                        <a href="/ctf/index.php?action=login" class="btn btn-hero-outline">Login</a>
                    </div>
                </div>

            </div>
        </main>

    <?php 
            include('view/shared/footer.php');
    }
?>
