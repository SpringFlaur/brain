<?php

namespace brain\frame;

use Slim\Slim;

class Rapid {

    /** @var Slim */
    protected $app;

    /** @var Route */
    protected $route;

    /** @var string */
    protected $namespace;

    public function __construct(Slim $app, $namespace) {
        $this->app = $app;
        $this->namespace = $namespace;
    }

    public function setRoute(Slim $app, $params) {
        $this->route = new Route($this->namespace, $app, $params);
    }

    public function run() {
        global $container;
        $controllerName = $this->route->getControllerName();
        $controller = new $controllerName($this->app, $container, $this->route);
        $method = $this->route->getActionName();
        $controller->$method();
    }

}