<?php
// File: controller/blog/post.php
// Description: Controller for single blog post

require_once(dirname(__DIR__, 2) . '/model/Blog.php');

$blog = new Blog();
$slug = $_GET['slug'] ?? null;

if (!$slug) {
    header('Location: /blog');
    exit();
}

$post = $blog->get_post($slug);

if (!$post) {
    header('Location: /blog');
    exit();
}

include(dirname(__DIR__, 2) . '/view/shared/header.php');
include(dirname(__DIR__, 2) . '/view/blog/post.php');
include(dirname(__DIR__, 2) . '/view/shared/footer.php');