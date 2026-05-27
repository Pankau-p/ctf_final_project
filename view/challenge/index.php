<main class="challenge-main">

    <a href="index.php?action=dashboard" class="challenge-back">← Back to Dashboard</a>

    <div class="challenge-card">

        <!-- ================================
             CARD TOP
             Difficulty and points badges
        ================================ -->
        <div class="challenge-card-top">
            <span class="challenge-badge challenge-badge-<?= $challenge['difficulty'] ?>"><?= ucfirst($challenge['difficulty']) ?></span>
            <span class="challenge-badge challenge-badge-pts"><?= $challenge['points'] ?>pts</span>
        </div>

        <div class="challenge-card-body">

            <!-- ================================
                 MAIN CONTENT
                 Title, description, flag submit
            ================================ -->
            <div class="challenge-content">

                <h1 class="challenge-title"><?= htmlspecialchars($challenge['title']) ?></h1>
                <p class="challenge-description"><?= htmlspecialchars($challenge['description']) ?></p>

                <?php if (!empty($error)): ?>
                    <p class="form-error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                    <p class="form-success"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <?php if (!$challenge['solved']): ?>
                    <div class="flag-box">
                        <div class="flag-box-label">Submit your flag</div>
                        <form method="post" action="index.php">
                            <input type="hidden" name="action" value="submit_flag">
                            <input type="hidden" name="challengeID" value="<?= $challenge['challengeID'] ?>">
                            <input
                                type="text"
                                name="flag"
                                class="flag-input"
                                placeholder="CTF{your_flag_here}"
                                autocomplete="off"
                                required>
                            <button type="submit" class="btn btn-primary btn-full">Submit Flag</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="flag-solved">
                        ✓ You solved this challenge on <?= date('M j, Y', strtotime($challenge['solved_at'])) ?>
                    </div>
                <?php endif; ?>

            </div>

            <!-- ================================
                 DIVIDER
            ================================ -->
            <div class="challenge-divider"></div>

            <!-- ================================
                 ASIDE
                 Solves, attempts, hint
            ================================ -->
            <aside class="challenge-aside">

                <div class="aside-stat">
                    <span class="aside-label">Solves</span>
                    <span class="aside-value"><?= $challenge['totalSolves'] ?></span>
                    <span class="aside-sub">people have solved this</span>
                </div>

                <div class="aside-divider"></div>

                <div class="aside-stat">
                    <span class="aside-label">Your Attempts</span>
                    <span class="aside-value aside-value-sm"><?= $challenge['attempts'] ?? 0 ?></span>
                </div>

                <div class="aside-divider"></div>

                <div class="aside-hints">
                    <span class="aside-label">Hints</span>
                    <?php if (!empty($challenge['hint'])): ?>
                        <button class="hint-btn" onclick="document.getElementById('hint-box').style.display='block'; this.style.display='none';">
                            💡 Reveal Hint
                        </button>
                        <div class="hint-box" id="hint-box" style="display: none;">
                            <?= htmlspecialchars($challenge['hint']) ?>
                        </div>
                    <?php else: ?>
                        <p class="aside-sub">No hints available.</p>
                    <?php endif; ?>
                </div>

            </aside>

        </div>
    </div>
</main>