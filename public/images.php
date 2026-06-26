<?php
$name = $_GET['name'] ?? '';

// Basic security check
if (!preg_match('/^[a-zA-Z0-9_-]+\.png$/', $name)) {
    abort(404);
}

$path = 'C:\Users\user\.gemini\antigravity-ide\brain\04e8c99a-9c1f-4f15-90c3-14b2824caf63\\' . $name;

if (file_exists($path)) {
    header('Content-Type: image/png');
    header('Access-Control-Allow-Origin: *');
    readfile($path);
    exit;
}

http_response_code(404);
echo "Image not found";
