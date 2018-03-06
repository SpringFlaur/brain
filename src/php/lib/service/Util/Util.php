<?php

namespace brain\service\Util;

//工具类
class Util {
    //取config.php中的配置
    public static function conf($key, $default = null) {
        global $container;
        $conf = $container['siteConf'];
        if (isset($conf[$key])) {
            return $conf[$key];
        } else {
            return $default;
        }
    }
}