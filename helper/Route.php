<?php

namespace Helper;

use Config\Quotes;
use Exception\NotFoundException;

class Route
{
    private static ?string $root = null;
    private static ?string $target = null;
    private static ?array $routes = null;
    private static ?array $over = null;

    public static function isApi(): bool
    {
        return self::routes()[0] === 'api';
    }

    public static function &routes(): array
    {
        if (self::$routes === null) {
            self::$routes = self::getRoutes($_SERVER['SCRIPT_URL']);
            if (empty(self::$routes[0])) self::$routes[0] = 'index';
        }
        return self::$routes;
    }

    /**
     * Returns routes using relative root
     * if project root is /quotes then routes is all after /quotes
     * @param string $path
     * @return array
     */
    public static function getRoutes(string $path): array
    {
        return array_values(
            array_diff_assoc(
                array_values(array_filter(explode('/', $path))),
                array_values(array_filter(explode('/', self::root())))
            )
        );
    }

    /**
     * Returns project root
     * @return string
     */
    public static function &root(): string
    {
        if (self::$root === null) self::$root = dirname($_SERVER['PHP_SELF']);
        return self::$root;
    }

    public static function &target(): string
    {
        if (self::$target === null) {
            self::$target = self::getTarget(self::routes());
        }
        return self::$target;
    }

    /**
     * Generate relative path to file
     * @param array $routes
     * @return string
     */
    public static function getTarget(array $routes): string
    {
        $point = Quotes::ROUTES;
        $path = [];
        foreach ($routes as $route) {
            if (isset($point[$route])) {
                $point = $point[$route];
                $path[] = $route;
            } else {
                if (isset($point['default_route']) && $point['default_route']) break;
                else throw NotFoundException::path(implode('/', $routes));
            }
        }
        return implode('/', $path);
    }

    public static function &over(): array
    {
        if (self::$over === null) {
            $point = Quotes::ROUTES;
            $path = [];
            foreach (self::routes() as $route) {
                if (isset($point[$route])) {
                    $point = $point[$route];
                } else {
                    $point = [];
                    $path[] = $route;
                }
            }
            self::$over = $path;
        }
        return self::$over;
    }
}
