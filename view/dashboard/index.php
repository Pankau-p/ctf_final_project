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
                    <span class="runner-card-label">Current Run</span>
                    <span class="runner-card-tagline">Keep going, Runner!</span>
                </div>
                <svg viewBox="0 0 80 80" class="runner-svg" xmlns="http://www.w3.org/2000/svg">
                    <!-- grid lines -->
                    <line x1="0" y1="80" x2="80" y2="40" stroke="#8b5cf6" stroke-width="0.4" opacity="0.4"/>
                    <line x1="0" y1="80" x2="80" y2="55" stroke="#8b5cf6" stroke-width="0.4" opacity="0.3"/>
                    <line x1="0" y1="80" x2="80" y2="65" stroke="#8b5cf6" stroke-width="0.4" opacity="0.2"/>
                    <line x1="0" y1="70" x2="80" y2="70" stroke="#8b5cf6" stroke-width="0.4" opacity="0.3"/>
                    <line x1="0" y1="60" x2="80" y2="60" stroke="#8b5cf6" stroke-width="0.4" opacity="0.2"/>
                    <!-- glow -->
                    <ellipse cx="40" cy="68" rx="14" ry="3" fill="#e8437a" opacity="0.2"/>
                    <!-- stickman -->
                    <circle cx="40" cy="20" r="6" fill="none" stroke="#e8437a" stroke-width="2"/>
                    <line x1="40" y1="26" x2="40" y2="45" stroke="#e8437a" stroke-width="2" stroke-linecap="round"/>
                    <line x1="40" y1="32" x2="30" y2="26" stroke="#e8437a" stroke-width="2" stroke-linecap="round"/>
                    <line x1="40" y1="32" x2="50" y2="38" stroke="#e8437a" stroke-width="2" stroke-linecap="round"/>
                    <line x1="40" y1="45" x2="30" y2="58" stroke="#e8437a" stroke-width="2" stroke-linecap="round"/>
                    <line x1="40" y1="45" x2="48" y2="56" stroke="#e8437a" stroke-width="2" stroke-linecap="round"/>
                    <!-- motion lines -->
                    <line x1="18" y1="30" x2="26" y2="30" stroke="#38bdf8" stroke-width="1.2" stroke-linecap="round" opacity="0.8"/>
                    <line x1="14" y1="36" x2="24" y2="36" stroke="#38bdf8" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                    <line x1="16" y1="42" x2="25" y2="42" stroke="#38bdf8" stroke-width="0.8" stroke-linecap="round" opacity="0.3"/>
                </svg>
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