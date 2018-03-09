<?php

namespace brain;

global $container;
global $APP_ROOT;

use brain\service\Util\Util;
use Medoo\Medoo;

include_once $APP_ROOT . '/etc/config.php';
global $siteConf;

$container['siteConf'] = $siteConf;

$container['db'] = function ($c) {
    return new Medoo(array(
        'database_type' => 'mysql',
        'database_name' => Util::conf('enjoy'),
        'server' => Util::conf('dbhost'),
        'username' => Util::conf('dbuser'),
        'password' => Util::conf('dbpassword'),
        'charset' => 'utf8'
    ));
};