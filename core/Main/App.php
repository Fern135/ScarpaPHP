<?php
include "../Router/Router.php";
use Oracle\Router; 

class App {
    protected $router;

    public function __construct() {
        $this->router = new Router();
    }

    public function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $route = $this->router->route($uri, $requestMethod);

        if ($route) {
            list($controller, $action) = explode('@', $route);
            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            // Handle 404 Not Found
            echo '404 - Not Found';
        }
    }
}
