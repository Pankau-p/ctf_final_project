<main class="auth-main">
    <div class="form-card">

        <div class="form-card-header">
            <h2 class="form-card-title">Register a new account.</h2>
            <p class="form-card-subtitle">Create a new OutRun account</p>
        </div>

        <?php if (!empty($error)): ?>
            <p class="form-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form id="register-form" method="post" action="index.php">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="form-input" required>
            </div>
           <div class="form-group">
                <label class="form-label" for="email">Country </label>
                <select name="country_code">
                    <?php foreach ($countries as $country) : ?>
                        <option value="<?= $country['countryCode'] ?>"
                            <?php if (($formData['countryCode'] ?? '') === $country['countryCode']) echo 'selected'; ?>>
                            <?= $country['countryName'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
           <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" required>
            </div>
           <div class="form-group">
                <label class="form-label" for="email">Avatar Url</label>
                <input type="url" id="avatar_url" name="avatar_url" class="form-input" placeholder="https://example.com/avatar.jpg">            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>
            <input type="hidden" name="action" value="register">
            <button type="submit" class="btn btn-primary btn-full">Register</button>
        </form>

        <p class="form-footer">Already have an account? <a href="index.php?action=login">Login</a></p>

    </div>
</main>