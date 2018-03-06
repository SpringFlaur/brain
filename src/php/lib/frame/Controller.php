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


    public function response($code, $msg = '', $data = [], $callback = '') {
        echo json_encode([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
        if ($callback != '') {
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }
            $callback();
        }
    }

}