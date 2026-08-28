<!--
File: view/blog/index.php
Description: Blog index page - list of all posts
-->

<main class="blog-main">

    <div class="blog-header">
        <h1 class="blog-title">Resources</h1>
        <p class="blog-subtitle">Notes, tools, and aha moments from learning pentesting.</p>
    </div>

    <?php if (empty($posts)): ?>
        <p class="form-error">No posts yet.</p>
    <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
                <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($post['slug']) ?>" class="blog-card">
                    <?php if ($post['category']): ?>
                        <span class="blog-card-category blog-category-<?= strtolower(htmlspecialchars($post['category'])) ?>">
                            <?= htmlspecialchars($post['category']) ?>
                        </span>
                    <?php endif; ?>
                    <h2 class="blog-card-title"><?= htmlspecialchars($post['title']) ?></h2>
                    <div class="blog-card-footer">
                        <div class="blog-card-tags">
                            <?php if (!empty($post['tags'])): ?>
                                <?php foreach ($post['tags'] as $tag): ?>
                                    <span class="blog-tag"><?= htmlspecialchars($tag) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <span class="blog-card-date"><?= htmlspecialchars($post['date']) ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>