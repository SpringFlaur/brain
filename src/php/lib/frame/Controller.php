<?php

namespace brain\frame;

use Pimple\Container;
use Slim\Slim;

class Controller {

    /** @var Slim */
    protected $app;

    /** @var Route */
    protected $route;

    /** @var Container */
    protected $container;

    public function __construct(Slim $app, $container, Route $route) {
        $this->app = $app;
        $this->container = $container;
        $this->route = $route;
    }


    public function response($code, $msg = '', $data = []) {
        echo json_encode([
            'code' => $code,
            'msg' => $msg,
            'data' => json_encode($data),
        ]);
        die;
    }

}