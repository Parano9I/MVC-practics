<?php

namespace Shop\Routes;

use Exception;

class Route
{
    private static $routes = [];
    private static $middlewares = [];
    public static $currentRoute;


    public static function add(array $route): void
    {
        array_push(self::$routes, $route);
    }

    public static function setMiddleware(string $conditionalParam = null, callable $callback): void
    {
        array_push(self::$middlewares, [
            'conditionalParam' => $conditionalParam,
            'callback' => $callback
        ]);
    }

    private static function useMiddlewares(array $route): void
    {
        foreach (self::$middlewares as $middleware) {
            if ($middleware['conditionalParam'] !== null) {
                $middleware['callback']($route[$middleware['conditionalParam']]);
            } else $middleware['callback']();
        }
    }

    public static function run(): void
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';
        if ($url !== '/') $url = trim($url, '/');

        $route = array_filter(self::$routes, function ($route) use ($url) {
            return $route['url'] === $url;
        });

        if (empty($route)) {
            http_response_code(404);
            die();
        }

        $route = array_values($route)[0];

        self::useMiddlewares($route);

        self::$currentRoute = $route;

        $class = 'Shop\Controllers\\' . $route['controller'] . 'Controller';
        $controller = new $class();
        $controller->{$route['action']}();
    }
}