<?php
$PHP_DIR = dirname(__DIR__);

//初始化路径变量，引用autoload.php，初始化container
include_once $PHP_DIR . '/lib/start.php';
//初始化设置，初始化工具
include_once $PHP_DIR . '/lib/init.php';

global $container;

var_dump($container['siteConf']);