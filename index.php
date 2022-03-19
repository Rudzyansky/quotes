<?php /** @noinspection PhpIncludeInspection */

use Exception\EngineException;
use Helper\Page;
use Helper\Route;

// Note: Folders and files must be in lowercase for default autoload.
// spl_autoload_extensions(".php");
// spl_autoload_register();

// Folders must be in lowercase, but filenames w/o changes
spl_autoload_register(function ($class) {
    $e = explode('\\', $class);
    for ($i = 0; $i < sizeof($e) - 1; $i++) $e[$i] = strtolower($e[$i]);
    require_once __DIR__ . '/' . implode('/', $e) . '.php';
});

session_start();

if (Route::isApi()) {
    try {
        header('Content-Type: application/json');
        http_response_code(200);
        include 'route.php';
    } catch (EngineException $e) {
        http_response_code($e->getCode());
        print json_encode($e);
    }
} else {
    try {
        include 'route.php';
    } catch (EngineException $e) {
        http_response_code($e->getCode());
        Page::print(
            $e->getCode() . ' ' . $e->getLocalized(),
            'error',
            $e->jsonSerialize(),
            ['common']
        );
    }
}
