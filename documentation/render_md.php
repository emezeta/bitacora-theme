<?php
// Include the Parsedown library using the correct absolute path
require_once '/home/obrasangiru/.local/share/composer/vendor/autoload.php'; 

function render_markdown_file($file_path) {
    // Check if the Markdown file exists
    if (file_exists($file_path)) {
        $markdown = file_get_contents($file_path);
        $parsedown = new Parsedown();
        return $parsedown->text($markdown);   
    }

    return '<p>Error: Markdown file not found.</p>';
}

// Usage - Replace 'your-markdown-file.md' with the actual name of your Markdown file
echo render_markdown_file(__DIR__ . '/css-tuning-guide.md');

