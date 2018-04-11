<?php

namespace brain\service\Util;

//工具类
class Util {
    /**
     * 取config.php中的配置
     * @param $key
     * @param null $default
     * @return null
     */
    public static function conf($key, $default = null) {
        global $container;
        $conf = $container['siteConf'];
        if (isset($conf[$key])) {
            return $conf[$key];
        } else {
            return $default;
        }
    }

    /**
     * 取请求中的自定义header参数
     * @param $key
     * @param null $default
     * @return null
     */
    public static function headerConf($key, $default = null) {
        $key = 'HTTP_' . strtoupper($key);
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        } else {
            return $default;
        }
    }
}