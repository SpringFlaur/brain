<?php

namespace brain;

global $container;
global $APP_ROOT;

use brain\service\Util\Util;

include_once $APP_ROOT . '/etc/config.php';
global $siteConf;

$container['siteConf'] = $siteConf;