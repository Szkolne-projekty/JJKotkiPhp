<?php

class Router
{
    private $routes = [];

    public function addRoute(string $method, string $path, callable $handler)
    {
        // Poprawiamy dopasowanie ścieżki, dodajemy odpowiednie escape'owanie
        $path = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $path = '#^' . str_replace('/', '\/', $path) . '$#';

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
        ];
    }

    private function getRouteByPath(string $name)
    {
        foreach ($this->routes as $route) {
            if (isset($route['path']) && $route['path'] === $name) {
                return $route;
            }
        }
        return null;
    }

    public function handleRequest()
    {
        $requestedMethod = $_SERVER['REQUEST_METHOD'];
        $requestedPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $queryParams = $_GET; // Pobieramy query parameters

        // Debugowanie, aby sprawdzić, czy ścieżka i parametry zapytania są poprawne
        // echo "Requested method: " . $requestedMethod . "\n";
        // echo "Requested path: " . $requestedPath . "\n";
        // var_dump($queryParams);

        foreach ($this->routes as $route) {
            // Debugowanie dopasowania
            // echo "Checking route: " . $route['path'] . "\n";
            if ($route['method'] === $requestedMethod && preg_match($route['path'], $requestedPath, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Jeśli zapytanie zawiera query parameters, dodajemy je do parametrów
                $params = array_merge($params, $queryParams);

                call_user_func_array($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        $notFoundRoute = $this->getRouteByPath('#^\/404$#');
        if ($notFoundRoute) {
            call_user_func($notFoundRoute['handler']);
        } else {
            echo "404 Not Found";
        }
    }
}
