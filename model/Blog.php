<?php
// File: model/Blog.php
// Description: Reads and parses markdown blog posts from the /posts directory

class Blog {
    private $posts_dir;
    private $parsedown;

    public function __construct() {
        $this->posts_dir = dirname(__DIR__) . '/posts/';
        require_once(dirname(__DIR__) . '/lib/Parsedown.php');
        $this->parsedown = new Parsedown();
        $this->parsedown->setSafeMode(true);
    }

    private function parse_frontmatter($content) {
    $frontmatter = [];
    $body = $content;

    if (strpos($content, '---') === 0) {
        $parts = explode('---', $content, 3);
        if (count($parts) >= 3) {
            $body = $parts[2];
            foreach (explode("\n", $parts[1]) as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                [$key, $value] = explode(':', $line, 2);
                $key = trim($key);
                $value = trim($value);
                // Handle tags array e.g. [nmap, recon]
                if (strpos($value, '[') === 0) {
                    $value = array_map('trim', explode(',', trim($value, '[]')));
                }
                $frontmatter[$key] = $value;
            }
        }
    }

    return ['frontmatter' => $frontmatter, 'body' => trim($body)];
    }

    public function get_all_posts() {
        $posts = [];
        $files = glob($this->posts_dir . '*.md');
    
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $parsed = $this->parse_frontmatter($content);
            $slug = basename($file, '.md');
            $posts[] = [
                'slug'     => $slug,
                'title'    => $parsed['frontmatter']['title'] ?? $slug,
                'date'     => $parsed['frontmatter']['date'] ?? '',
                'category' => $parsed['frontmatter']['category'] ?? '',
                'tags'     => $parsed['frontmatter']['tags'] ?? [],
            ];
        }
    
        // Sort by date descending
        usort($posts, fn($a, $b) => strcmp($b['date'], $a['date']));
    
        return $posts;
    }

    public function get_post($slug) {
    $file = $this->posts_dir . $slug . '.md';

    if (!file_exists($file)) {
        return null;
    }

    $content = file_get_contents($file);
    $parsed = $this->parse_frontmatter($content);

    return [
        'slug'     => $slug,
        'title'    => $parsed['frontmatter']['title'] ?? $slug,
        'date'     => $parsed['frontmatter']['date'] ?? '',
        'category' => $parsed['frontmatter']['category'] ?? '',
        'tags'     => $parsed['frontmatter']['tags'] ?? [],
        'html'     => $this->parsedown->text($parsed['body']),
    ];
    }
}