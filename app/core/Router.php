<?php
class Router {
    private $routes = [];

    public function add($route, $params = []) {
        // Convert route to regex
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9-]+)', $route);
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function dispatch($url) {
        $url = parse_url($url, PHP_URL_PATH);

        // Remove base url if it exists in path (for local subfolder dev)
        $base_path = parse_url(BASE_URL, PHP_URL_PATH);
        if ($base_path && strpos($url, $base_path) === 0) {
            $url = substr($url, strlen($base_path));
        }

        // Default home route
        if ($url === '/' || $url === '') {
            $controllerName = 'HomeController';
            $actionName = 'index';
            $controller = new $controllerName();
            $controller->$actionName();
            return;
        }

        // Check defined routes
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {

                $controllerName = $params['controller'] ?? 'HomeController';
                $actionName = $params['action'] ?? 'index';

                // Pass dynamic segments to action
                $args = [];
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $args[$key] = $match;
                    }
                }

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (is_callable([$controller, $actionName])) {
                        call_user_func_array([$controller, $actionName], [$args]);
                        return;
                    }
                }
            }
        }

        // Basic dynamic routing fallback (e.g., /admin/login -> AdminController::login())
        $parts = explode('/', trim($url, '/'));

        // Handle SEO image page, e.g., /category-slug/image-slug/
        if (count($parts) == 2 && $parts[0] !== 'admin') {
            $controller = new HomeController();
            $controller->image(['category_slug' => $parts[0], 'image_slug' => $parts[1]]);
            return;
        }

        // Handle category page, e.g., /category-slug/
        if (count($parts) == 1 && $parts[0] !== 'admin') {
            $controller = new HomeController();
            $controller->category(['category_slug' => $parts[0]]);
            return;
        }

        $controllerName = ucfirst($parts[0] ?? 'Home') . 'Controller';

        // Convert dash-case to camelCase for method names (e.g., bulk-upload -> bulkUpload)
        $actionRaw = $parts[1] ?? 'index';
        $actionName = lcfirst(str_replace('-', '', ucwords($actionRaw, '-')));

        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (is_callable([$controller, $actionName])) {
                $controller->$actionName();
                return;
            }
        }

        // 404
        self::serve404();
    }

    public static function serve404() {
        if (!headers_sent()) {
            header("HTTP/1.0 404 Not Found");
        }
        $meta_title = "404 Not Found | Pixvora";
        $meta_description = "The page you are looking for does not exist.";
        $content_view = APP_DIR . '/views/home/404.php';
        require_once APP_DIR . '/views/layouts/main.php';
        exit;
    }
}
