<?php

$APP_ROOT = realpath(__DIR__ . '/../../..') . '/';

require_once $APP_ROOT . '/vendor/autoload.php';

date_default_timezone_set("Asia/Shanghai");

$container = new \Pimple\Container();