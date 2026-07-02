<!--
File: view/blog/post.php
Description: Single blog post view
-->

<main class="post-main">

    <div class="post-wrap">

        <a href="/blog" class="challenge-back">← Back to Resources</a>

        <!-- Meta -->
        <div class="post-meta">
            <?php if ($post['category']): ?>
                <span class="blog-card-category blog-category-<?= strtolower(htmlspecialchars($post['category'])) ?>">
                    <?= htmlspecialchars($post['category']) ?>
                </span>
            <?php endif; ?>
            <?php if (!empty($post['tags'])): ?>
                <?php foreach ($post['tags'] as $tag): ?>
                    <span class="blog-tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
            <span class="post-date"><?= htmlspecialchars($post['date']) ?></span>
        </div>

        <!-- Title -->
        <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>

        <div class="post-divider"></div>

        <!-- Content -->
        <div class="post-body">
            <?= $post['html'] ?>
        </div>

    </div>

</main>