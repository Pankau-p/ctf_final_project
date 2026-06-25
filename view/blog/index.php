<!--
File: view/blog/index.php
Description: Blog index page - list of all posts
-->
<main>
    <h1>Blog</h1>
    <p class="landing-subtitle">Notes, tools, and aha moments from learning pentesting.</p>

    <?php if (empty($posts)): ?>
        <p class="form-error">No posts yet.</p>
    <?php else: ?>
        <div class="challenge-list">
            <?php foreach ($posts as $post): ?>
                <div class="challenge-row">
                    <span class="challenge-name">
                        <a href="/ctf/blog/<?= htmlspecialchars($post['slug']) ?>">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </span>
                    <div class="challenge-meta">
                        <?php if ($post['category']): ?>
                            <span class="challenge-badge challenge-badge-pts"><?= htmlspecialchars($post['category']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($post['tags'])): ?>
                            <?php foreach ($post['tags'] as $tag): ?>
                                <span class="challenge-badge challenge-badge-easy"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <span class="challenge-badge"><?= htmlspecialchars($post['date']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>