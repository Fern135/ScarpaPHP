<?php

namespace Scarpa\router;

class Router {
    protected $routes = [];

    public function get($uri, $controllerAction) {
        $this->routes["GET"][$uri] = $controllerAction;
    }

    public function post($uri, $controllerAction) {
        $this->routes["POST"][$uri] = $controllerAction;
    }

    public function put($uri, $controllerAction){
        $this->routes["PUT"][$uri] = $controllerAction;
    }

    public function delete($uri, $controllerAction){
        $this->routes["DELETE"][$uri] = $controllerAction;
    }

    public function route($uri, $requestMethod) {
        if (array_key_exists($uri, $this->routes[$requestMethod])) {
            return $this->routes[$requestMethod][$uri];
        }
        return null;
    }
}
