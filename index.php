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
    define('BASE_URL', '');
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
        header('Location: ' . BASE_URL . '/index.php');
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

        <!-- ================================
             HERO
             Dark gradient, grid lines, CTA
        ================================ -->
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
                <p class="landing-subtitle">Beginner-friendly challenges, hints along the way, and a leaderboard to climb.</p>
                <div class="landing-actions">
                    <a href="<?= BASE_URL ?>/index.php?action=register" class="btn btn-hero-primary">Get Started</a>
                    <a href="<?= BASE_URL ?>/index.php?action=login" class="btn btn-hero-outline">Login</a>
                </div>
                <p class="landing-hero-sub">HorizonCTF is a free, beginner-friendly platform built for people who are curious about cybersecurity but don't know where to start. No prior experience required — just a browser and a willingness to dig in.</p>
            </div>
        </div>

        <div class="landing-divline"></div>

        <!-- ================================
             HOW IT WORKS
             Three alternating two-col rows
        ================================ -->
        <section class="landing-section">
            <h2 class="landing-section-title">How it works</h2>
            <p class="landing-section-intro">CTF stands for Capture the Flag. The idea is simple: find the hidden flag, submit it, earn points. But getting there is where it gets interesting.</p>
            <p class="landing-section-intro">Flags are hidden everywhere — inside HTML source code, buried in HTTP headers, encoded in strings that look like gibberish until you know what to look for. Every challenge teaches you a real technique that real hackers use. You're not playing a game. You're learning a craft.</p>
            <p class="landing-section-intro">Start small. Think differently. The flags don't give themselves up easily — but when they do, you'll understand something about the web that most people never will.</p>

            <div class="landing-two-col">
                <div class="landing-visual">
                    <div class="landing-visual-dot" style="background: #ff2d6b;"></div>
                    <div class="landing-visual-line" style="width: 70%;"></div>
                    <div class="landing-visual-line" style="width: 50%; background: #7c3aed;"></div>
                    <div class="landing-visual-line" style="width: 85%; background: #38bdf8;"></div>
                    <code class="landing-visual-code">CTF{hidden_in_plain_sight}</code>
                    <span class="landing-visual-success">✓ flag found</span>
                </div>
                <div class="landing-copy">
                    <h3 class="landing-copy-title">01 — Learn</h3>
                    <p class="landing-copy-text">Read writeups, discover tools, and build your foundations on the Resources page. Real techniques, explained simply.</p>
                </div>
            </div>

            <div class="landing-two-col landing-two-col-reverse">
                <div class="landing-copy">
                    <h3 class="landing-copy-title">02 — Hack</h3>
                    <p class="landing-copy-text">Put your knowledge to the test with real CTF-style challenges designed for beginners. Each one is a self-contained puzzle — inspect, probe, decode, and think sideways until you find what's hidden.</p>
                </div>
                <div class="landing-visual">
                    <code class="landing-visual-code" style="color: #a78bfa;">GET /index.php HTTP/1.1</code>
                    <code class="landing-visual-code" style="color: #a78bfa;">Host: horizonctf.com</code>
                    <code class="landing-visual-code" style="color: #4ade80; margin-top: 0.5rem;">X-Secret-Flag: CTF{...}</code>
                    <div class="landing-visual-line" style="width: 60%; margin-top: 0.75rem;"></div>
                    <div class="landing-visual-line" style="width: 40%;"></div>
                </div>
            </div>

            <div class="landing-two-col">
                <div class="landing-visual" style="align-items: center; justify-content: center;">
                    <span class="landing-visual-rank">#1</span>
                    <span class="landing-visual-rank-label">your rank</span>
                    <div class="landing-visual-line" style="width: 40%; margin-top: 0.5rem;"></div>
                </div>
                <div class="landing-copy">
                    <h3 class="landing-copy-title">03 — Compete</h3>
                    <p class="landing-copy-text">Every flag you capture earns points and moves you up the leaderboard. You're not just solving puzzles — you're racing. And the competition is live.</p>
                </div>
            </div>
        </section>

        <div class="landing-divline"></div>

        <!-- ================================
             CHALLENGE PREVIEW
             2 challenge cards, CTA
        ================================ -->
        <section class="landing-section">
            <h2 class="landing-section-title">Challenges</h2>
            <p class="landing-section-intro">Here's a taste of what's waiting for you.</p>
            <div class="landing-challenge-grid">
                <div class="landing-challenge-card">
                    <div class="landing-challenge-top">
                        <span class="challenge-badge challenge-badge-easy">Easy</span>
                        <span class="challenge-badge challenge-badge-pts">10pts</span>
                    </div>
                    <div class="landing-challenge-body">
                        <span class="landing-challenge-name">What Lies Beneath</span>
                        <br>
                        <span class="landing-challenge-subtitle">Sometimes developers leave notes where they shouldn't.</span>

                    </div>
                </div>
                <div class="landing-challenge-card">
                    <div class="landing-challenge-top">
                        <span class="challenge-badge challenge-badge-medium">Medium</span>
                        <span class="challenge-badge challenge-badge-pts">25pts</span>
                    </div>
                    <div class="landing-challenge-body">
                        <span class="landing-challenge-name">Encoded Secrets</span>
                        <br>
                        <span class="landing-challenge-subtitle">Think about common encoding schemes used on the web. The = at the end is a clue....</span>
                    </div>
                </div>
            </div>
            <div class="landing-cta-row">
                <a href="<?= BASE_URL ?>/index.php?action=register" class="btn btn-hero-primary">Start Running →</a>
            </div>
        </section>

        <div class="landing-divline"></div>

        <!-- ================================
             LEADERBOARD + BLOG TEASER
             Two columns side by side
        ================================ -->
        <section class="landing-section landing-split">

            <div class="landing-split-col">
                <h2 class="landing-split-title">Leaderboard</h2>
                <p class="landing-split-sub">Real players. Real competition.</p>
                <div class="landing-lb">
                    <div class="landing-lb-row"><span>1. alice</span><span class="landing-lb-pts">85pts</span></div>
                    <div class="landing-lb-row"><span>2. bob</span><span class="landing-lb-pts">60pts</span></div>
                    <div class="landing-lb-row"><span>3. carol</span><span class="landing-lb-pts">50pts</span></div>
                    <div class="landing-lb-row"><span>4. marco</span><span class="landing-lb-pts">35pts</span></div>
                    <div class="landing-lb-row"><span>5. priya</span><span class="landing-lb-pts">20pts</span></div>
                </div>
            </div>

            <div class="landing-split-col">
                <h2 class="landing-split-title">Latest Posts</h2>
                <p class="landing-split-sub">Not sure where to start? The Resources page has you covered.</p>
                <div class="landing-posts">
                    <div class="landing-post-row">What are HTTP headers? <span class="landing-post-meta">· Web · May 2026</span></div>
                    <div class="landing-post-row">Base64 is not encryption <span class="landing-post-meta">· Crypto · May 2026</span></div>
                    <div class="landing-post-row">No Robots: what is robots.txt? <span class="landing-post-meta">· Web · Jun 2026</span></div>
                </div>
            </div>

        </section>

        <div class="landing-divline"></div>

        <!-- ================================
             FINAL CTA
             Dark strip, bold line, register
        ================================ -->
        <section class="landing-cta-final">
            <h2 class="landing-cta-title">The finish line won't come to you.</h2>
            <p class="landing-cta-text">Cybersecurity isn't just for experts. It starts with curiosity — and the willingness to look a little closer than everyone else. HorizonCTF was built for that moment.</p>
            <p class="landing-cta-text">Create your account. Start running.</p>
            <a href="<?= BASE_URL ?>/index.php?action=register" class="btn btn-hero-primary">Create Account</a>
        </section>

    </main>

<?php 
    include('view/shared/footer.php');
}
?>
