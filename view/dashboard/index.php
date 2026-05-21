<?php
// File: view/dashboard/index.php
//
// Author: 
// Course: COMP 3541 - Web Programming
// Date: 2026-05-19
//
// Final
//
// Description: Displays the User Dashboard page
// Also shows a logout button. 
?>

<main>
    <h1>Dashboard</h1>
    <h2>Login Status</h2>
    <p>You are logged in as <?php echo htmlspecialchars($_SESSION['user_firstName']) ?></p>
    <form method="post" action='index.php'>
        <input type="hidden" name="action" value="logout">
            <button type="submit">Logout</button>
    </form>
</main>