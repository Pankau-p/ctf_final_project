<?php
// File: controller/blog/index.php
// Description: Controller for blog index page

require_once(dirname(__DIR__, 2) . '/model/Blog.php');

$blog = new Blog();
$posts = $blog->get_all_posts();

include(dirname(__DIR__, 2) . '/view/shared/header.php');
include(dirname(__DIR__, 2) . '/view/blog/index.php');
include(dirname(__DIR__, 2) . '/view/shared/footer.php');