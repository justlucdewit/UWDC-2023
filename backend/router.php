<?php
class Router {
    public function registerRoute($method, $route, $callback) {
        
        // Preprocess the route
        // Remove the last / if it exists
        $currentRoute = $_SERVER['REQUEST_URI'];
        $currentRoute = $this->preprocessRoute($currentRoute);
        $route = rtrim($route, '/');

        // Preprocess the method
        // Convert to uppercase
        $currentMethod = $_SERVER['REQUEST_METHOD'];
        $method = strtoupper($method);
        
        if ($currentMethod === $method && $currentRoute === $route) {
            $response = $callback();
            
            if ($response != NULL) {
                http_response_code($response);
            }

            exit();
        }
    }

    public function registerController($route, $controller) {
        // Controller is some php class
        $controllerRoutes = ["get", "post", "delete"];

        // Loop over each controller route
        foreach ($controllerRoutes as $controllerRoute) {
            // Check if the controller has a method for the route
            if (method_exists($controller, $controllerRoute)) {
                // Register the route
                $this->registerRoute($controllerRoute, $route, function() use ($controller, $controllerRoute) {
                    return $controller->$controllerRoute();
                });
            }
        }
    }

    private function preprocessRoute($route) {
        // Replace double slashes with single slashes
        $route = preg_replace('/\/+/', '/', $route);

        // Remove the last / if it exists
        $route = rtrim($route, '/');

        // Remove the fragment if it exists
        if (strpos($route, '#') !== false) {
            $route = substr($route, 0, strpos($route, '#'));
        }

        // Isolate the query string if it exists
        $queryString = '';
        if (strpos($route, '?') !== false) {
            $queryString = substr($route, strpos($route, '?'));
            $route = substr($route, 0, strpos($route, '?'));
        }

        return $route;
    }
}