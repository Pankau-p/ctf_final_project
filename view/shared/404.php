<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

http_response_code(404);
include($_SERVER['DOCUMENT_ROOT'] . '/view/shared/header.php');
?>


<main class="landing">
    <div class="landing-hero">
        <div class="landing-content">
            <h1 class="landing-title">
                4<span class="landing-title-accent">0</span>4
            </h1>

            <p class="landing-subtitle">
                Signal lost. The page you're looking for could not be located.
            </p>

            <p class="landing-subtitle">
                The target may have moved, been deleted, or never existed.
                No flags were found at this location.
            </p>

            <div class="landing-actions">
                <a href="<?= BASE_URL ?>/" class="btn btn-primary">
                    Return to Base
                </a>
            </div>
        </div>
    </div>
</main>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/view/shared/footer.php');
?>