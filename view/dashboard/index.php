<main class="dashboard-main">
    <div class="dashboard-layout">

        <!-- ================================
             LEFT COLUMN
             Runner card, stats, leaderboard
        ================================ -->
        <aside class="dashboard-sidebar">

            <!-- Runner Card -->
            <div class="runner-card">
                <div class="runner-card-text">
                    <span class="runner-card-label">Started at the bottom, now were here...</span>
                    <span class="runner-card-tagline">Keep going, Runner!</span>
                </div>
            </div>

            <!-- Stats Table -->
            <div class="stats-card">
                <span class="sidebar-card-title">Your Stats</span>
                <table class="stats-table">
                    <tr>
                        <td class="stats-table-label">Points</td>
                        <td class="stats-table-value stat-pink"><?= $stats['totalPoints'] ?></td>
                    </tr>
                    <tr>
                        <td class="stats-table-label">Solved</td>
                        <td class="stats-table-value stat-purple"><?= $stats['totalSolved'] ?></td>
                    </tr>
                    <tr>
                        <td class="stats-table-label">Attempts</td>
                        <td class="stats-table-value stat-blue"><?= $stats['totalAttempts'] ?></td>
                    </tr>
                    <tr>
                        <td class="stats-table-label">Rank</td>
                        <td class="stats-table-value stat-pink">#<?= $stats['rank'] ?></td>
                    </tr>
                </table>
            </div>

            <!-- Leaderboard -->
            <div class="leaderboard-card">
                <span class="sidebar-card-title">Leaderboard</span>
                <table class="leaderboard-table">
                    <?php foreach ($leaderboard as $index => $entry): ?>
                        <tr class="<?= $entry['username'] === $user['username'] ? 'leaderboard-row-me' : '' ?>">
                            <td class="leaderboard-rank"><?= $index + 1 ?></td>
                            <td class="leaderboard-name"><?= htmlspecialchars($entry['username']) ?></td>
                            <td class="leaderboard-points"><?= $entry['totalPoints'] ?>pts</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </aside>

        <!-- ================================
             RIGHT COLUMN
             Progress bar and challenges
        ================================ -->
        <div class="dashboard-content">

            <!-- Progress Bar -->
            <div class="progress-card">
                <div class="progress-header">
                    <span class="progress-label">Overall Progress</span>
                    <span class="progress-count"><?= $progress['solved'] ?> / <?= $progress['total'] ?> challenges</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: <?= ($progress['total'] > 0) ? round(($progress['solved'] / $progress['total']) * 100) : 0 ?>%"></div>
                </div>
            </div>

            <!-- Challenges -->
            <div class="challenges-card">
                <span class="sidebar-card-title">Challenges</span>
                <div class="challenge-list">
                    <?php foreach ($challenges as $challenge): ?>
                        <div class="challenge-row <?= $challenge['solved'] ? 'challenge-row-solved' : '' ?>">
                            <span class="challenge-name"><?= htmlspecialchars($challenge['title']) ?></span>
                            <div class="challenge-meta">
                                <span class="challenge-badge challenge-badge-<?= $challenge['difficulty'] ?>"><?= ucfirst($challenge['difficulty']) ?></span>
                                <span class="challenge-badge challenge-badge-pts"><?= $challenge['points'] ?>pts</span>
                                <?php if ($challenge['solved']): ?>
                                    <span class="challenge-badge challenge-badge-solved">✓ Solved</span>
                                <?php else: ?>
                                    <a href="index.php?action=challenge&id=<?= $challenge['challengeID'] ?>" class="btn btn-outline">Start</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</main>