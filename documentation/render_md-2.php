<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$autoload = '/home/dosmilun/.local/share/composer/vendor/autoload.php';
if (!file_exists($autoload)) {
    die("Error: Autoload no encontrado: $autoload\n");
}
require_once $autoload;

function render_markdown_file($file_path) {
    if (file_exists($file_path)) {
        $markdown = file_get_contents($file_path);
        $parsedown = new Parsedown();
        return $parsedown->text($markdown);
    }
    return '<p>Error: Markdown file not found: ' . $file_path . '</p>';
}

// Verificar argumentos
if ($argc < 2) {
    die("Uso: php render_md.php <archivo.md>\nEjemplo: php render_md.php hola.md\n");
}

$file_path = $argv[1];
echo '<!doctype html><html><head><meta http-equiv="content-type" content="text/html; charset=utf-8" /></head><body> ';

echo render_markdown_file($file_path);

echo ' </body></html>';

