<?php

use Helper\Access;
use Helper\Page;
use Helper\Route;

$root = Route::root();
$query = $_SERVER['QUERY_STRING'];

if (Access::isLogged()) {
    $routes = Route::getRoutes($query);
    Route::getTarget($routes); // check correct (throws exception in case of not found)
    header("Location: $root/" . implode('/', $routes));
} else {
    Page::printDefaultWoLoader("Log in", [
        'right' => "<a href=\"$root/signup?$query\">signup</a>"
    ]);
}
