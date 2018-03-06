<?php

namespace brain\frame;

use Pimple\Container;
use Slim\Slim;

class Route {

    /** @var Slim */
    protected $app;

    protected $uri;

    /** @var string */
    protected $controllerName;

    /** @var string */
    protected $actionName;

    /** @var array */
    protected $params;

    /** @var Container */
    protected $container;

    public function __construct($namespace, $app, $uri) {
        $this->uri = $uri;
        $this->parse($namespace, $app);
    }

    public function parse($namespace, Slim $app) {
        $uriArray = $this->uri;
        for ($i = count($uriArray) - 1; $i >= 0; $i--) {
            $end = array_pop($uriArray);
            $controllerName = $namespace . '\\' . join('\\', $uriArray) . '\\' . ucfirst($end);
            if (class_exists($controllerName)) {
                $this->controllerName = $controllerName;
                break;
            } else {
                array_unshift($this->params, $end);
            }
        }
        if (!$this->controllerName) {
            throw new \Exception('no route', -1);
        } else {
            $this->actionName = strtolower($app->request->getMethod()) . 'Action';
        }
    }

    /**
     * @return string
     */
    public function getControllerName() {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName() {
        return $this->actionName;
    }
}