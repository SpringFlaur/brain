<?php
phpinfo();

use brain\frame\Rapid;

$PHP_DIR = dirname(__DIR__);

//初始化路径变量，引用autoload.php，初始化container
include_once $PHP_DIR . '/lib/start.php';
//初始化设置，初始化工具
include_once $PHP_DIR . '/lib/init.php';

global $container;


$app = new \Slim\Slim();
$method = strtolower($app->request->getMethod());
$app->$method('(/:params+)', function ($params) use ($app) {
    $rapid = new Rapid($app, 'brain\\api');
    $rapid->setRoute($app, $params);
    $rapid->run();
});
$app->run();