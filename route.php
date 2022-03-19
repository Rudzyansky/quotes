<?php

use Exception\EngineException;
use Exception\NotFoundException;
use Exception\UnexpectedException;
use Helper\Route;

try {
    $path = __DIR__ . '/routes/' . Route::target() . '.php';
    if (is_file($path) && is_readable($path)) include $path;
    else throw NotFoundException::default();
} catch (EngineException $e) {
    throw $e;
} catch (Throwable $e) {
    throw UnexpectedException::from($e);
}
