<?php 
    session_start();

    require_once('./config/db.php');

    // Determine action from POST or GET
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    if ($action === 'login') {
        include('view/shared/header.php');
        include('view/login/login.php');
        include('view/shared/footer.php');
    } elseif ($action === 'register') {
        include('view/shared/header.php');
        include('view/register/register.php');
        include('view/shared/footer.php');
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
