<?php

use Exception\NotFoundException;
use Helper\Route;

$path = __DIR__ . '/../../' . Route::target() . '/' . implode('/', Route::over());
if (!is_file($path) || !is_readable($path)) throw NotFoundException::default();

$data = [
    'root' => Route::root()
];

$body = file_get_contents($path);
foreach ($data as $key => $value) {
    $body = str_replace("%$key%", $value, $body);
}

header('Content-type: application/javascript; charset=utf-8');
print $body;
