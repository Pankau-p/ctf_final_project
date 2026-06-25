<!--
File: view/blog/post.php
Description: Single blog post view
-->
<main>
    <a href="/blog" class="challenge-back">← Back to Blog</a>
    
    <div class="challenge-card">
        <div class="challenge-card-top">
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

        <div class="challenge-card-body">
            <div class="challenge-content">
                <h1 class="challenge-title"><?= htmlspecialchars($post['title']) ?></h1>
                <div class="blog-content">
                    <?= $post['html'] ?>
                </div>
            </div>
        </div>
    </div>
</main>