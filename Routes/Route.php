<?php

namespace Shop\Routes;

use Exception;

class Route
{
    private static $routes = [];
    public static $currentRoute;

    public static function add(array $route): void
    {
        array_push(self::$routes, $route);
    }

    public static function run(): void
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');

        $route = array_filter(self::$routes, function ($route) use ($url) {
            return $route['url'] === $url;
        });

        if (empty($route)) {
            http_response_code(404);
            die();
        }

        $route = 2array_values($route)[0];

        self::$currentRoute = $route;

        $class = 'Shop\Controllers\\' . $route['controller'] . 'Controller';
        $controller = new $class();
        $controller->{$route['action']}();
    }
}