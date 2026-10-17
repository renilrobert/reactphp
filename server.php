<?php

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (!is_string($requestPath)) {
    http_response_code(400);
    exit('Invalid request path');
}

$prefix = '/reactphp';
if ($requestPath === $prefix) {
    header('Location: /reactphp/', true, 302);
    exit;
}

if (strncmp($requestPath, $prefix . '/', strlen($prefix) + 1) === 0) {
    $requestPath = substr($requestPath, strlen($prefix));
}

$root = realpath(__DIR__);
$relativePath = rawurldecode(ltrim($requestPath, '/'));
$file = realpath($root . DIRECTORY_SEPARATOR . $relativePath);
$rootPrefix = $root . DIRECTORY_SEPARATOR;

if (
    $file !== false
    && is_file($file)
    && strncmp(strtolower($file), strtolower($rootPrefix), strlen($rootPrefix)) === 0
) {
    if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'php') {
        require $file;
        exit;
    }

    $contentTypes = [
        'css' => 'text/css; charset=utf-8',
        'gif' => 'image/gif',
        'ico' => 'image/x-icon',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
    ];
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    header('Content-Type: ' . ($contentTypes[$extension] ?? 'application/octet-stream'));
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

require $root . DIRECTORY_SEPARATOR . 'index.php';
