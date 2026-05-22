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

<?php include 'view/shared/header.php'; ?>

<main class="dashboard-main">

    <!-- ================================
         DASHBOARD HEADER
         Welcome message and user info
    ================================ -->
    <div class="dashboard-header">
        <div class="dashboard-welcome">
            <h1 class="dashboard-title">Welcome back, <?= htmlspecialchars($user['firstName']) ?>.</h1>
            <p class="dashboard-subtitle">Keep going, Runner. The finish line is closer than you think.</p>
        </div>
        <div class="dashboard-avatar">
            <?php if (!empty($user['avatar_url'])): ?>
                <img src="<?= htmlspecialchars($user['avatar_url']) ?>" alt="Avatar" class="avatar-img">
            <?php else: ?>
                <div class="avatar-placeholder"><?= strtoupper($user['firstName'][0]) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================================
         STATS ROW
         Points, solved, attempts, rank
    ================================ -->
    <div class="stats-row">
        <div class="stat-card">
            <span class="stat-label">Total Points</span>
            <span class="stat-value stat-pink"><?= $stats['totalPoints'] ?></span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Challenges Solved</span>
            <span class="stat-value stat-purple"><?= $stats['totalSolved'] ?></span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Attempts</span>
            <span class="stat-value stat-blue"><?= $stats['totalAttempts'] ?></span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Global Rank</span>
            <span class="stat-value stat-pink">#<?= $stats['rank'] ?></span>
        </div>
    </div>

    <!-- ================================
         PROGRESS BAR
         How many challenges solved
    ================================ -->
    <div class="progress-section">
        <div class="progress-header">
            <span class="progress-label">Your Run</span>
            <span class="progress-count"><?= $progress['solved'] ?> / <?= $progress['total'] ?> challenges complete</span>
        </div>
        <div class="progress-track">
            <div class="progress-fill" style="width: <?= ($progress['total'] > 0) ? round(($progress['solved'] / $progress['total']) * 100) : 0 ?>%"></div>
            <span class="progress-runner">🏃</span>
        </div>
    </div>

    <!-- ================================
         DASHBOARD BODY
         Challenges left, leaderboard right
    ================================ -->
    <div class="dashboard-body">

        <!-- CHALLENGES -->
        <div class="dashboard-challenges">
            <h2 class="section-title">Challenges</h2>
            <div class="challenge-grid">
                <?php foreach ($challenges as $challenge): ?>
                    <div class="challenge-tile <?= $challenge['solved'] ? 'challenge-tile-solved' : '' ?>">
                        <div class="challenge-tile-header">
                            <span class="challenge-title"><?= htmlspecialchars($challenge['title']) ?></span>
                            <span class="challenge-badge challenge-badge-<?= $challenge['difficulty'] ?>">
                                <?= ucfirst($challenge['difficulty']) ?>
                            </span>
                        </div>
                        <div class="challenge-tile-footer">
                            <span class="challenge-points"><?= $challenge['points'] ?>pts</span>
                            <?php if ($challenge['solved']): ?>
                                <span class="challenge-solved">✓ Solved</span>
                            <?php else: ?>
                                <a href="index.php?action=challenge&id=<?= $challenge['challengeID'] ?>" class="btn btn-outline">Start</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- LEADERBOARD -->
        <div class="dashboard-leaderboard">
            <h2 class="section-title">Leaderboard</h2>
            <div class="leaderboard-card">
                <?php foreach ($leaderboard as $index => $entry): ?>
                    <div class="leaderboard-row <?= $entry['username'] === $user['username'] ? 'leaderboard-row-me' : '' ?>">
                        <span class="leaderboard-rank"><?= $index + 1 ?></span>
                        <span class="leaderboard-name"><?= htmlspecialchars($entry['username']) ?></span>
                        <span class="leaderboard-points"><?= $entry['totalPoints'] ?>pts</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</main>

<?php include 'view/shared/footer.php'; ?>