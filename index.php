<?php 
    session_start();

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
    } else { 
        include('view/shared/header.php');
        ?>
        <main class="landing">
            <div class="landing-hero">
                <h1 class="landing-title">Capture The Flag.</h1>
                <p class="landing-subtitle">Train your skills. Solve challenges. Climb the board.</p>
                <div class="landing-actions">
                    <a href="/ctf/index.php?action=register" class="btn btn-primary">Get Started</a>
                    <a href="/ctf/index.php?action=login" class="btn btn-outline">Login</a>
                </div>
            </div>
        </main>
    <?php 
            include('view/shared/footer.php');
    }
?>
