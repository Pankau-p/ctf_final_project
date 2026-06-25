<!--

File: view/about/index.php

Author: YK
Course: COMP 3541 - Web Programming
Date: 2026-05-28

Final

Description: View for the about page
-->
<?php 
    $page_title = 'About | OutRun CTF';
    $page_description = 'Learn about OutRun CTF, a beginner-friendly capture the flag training platform.';
    include 'view/shared/header.php'; 
?>

<main class="about-main">

    <div class="about-card">

        <div class="about-header">
            <h1 class="about-title">About</h1>
            <p class="about-subtitle">A beginner-friendly CTF platform.</p>
        </div>

        <div class="about-body">
            <p>HorizonCTF is a beginner-friendly Capture the Flag platform for anyone curious about cybersecurity. The challenges are approachable, hints are available, and nothing assumes prior experience. Built for people who want to get started but don't know where.</p>
        </div>

    </div>

</main>

<?php include 'view/shared/footer.php'; ?>