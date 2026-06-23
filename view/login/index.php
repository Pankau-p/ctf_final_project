<!--

File: view/login/index.php

Author: YK
Course: COMP 3541 - Web Programming
Date: 2026-05-28

Final

Description: View for the login page
-->

<main class="auth-main">
    <div class="form-card">

        <!-- Login Card -->
        <div class="form-card-header">
            <h2 class="form-card-title">Welcome back</h2>
            <p class="form-card-subtitle">Sign in to your OutRun account</p>
        </div>

        <?php if (!empty($error)): ?>
            <p class="form-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form id="login-form" method="post" action="index.php">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="example@example.com" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>
            <input type="hidden" name="action" value="login">
            <button type="submit" class="btn btn-primary btn-full">Login</button>
        </form>

        <p class="form-footer">Don't have an account? <a href="index.php?action=register">Sign up</a></p>

    </div>
</main>