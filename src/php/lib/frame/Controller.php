<?php

namespace brain\frame;

use brain\service\user\UserService;
use brain\service\Util\Util;
use Pimple\Container;
use Slim\Slim;

class Controller {

    /** @var Slim */
    protected $app;

    /** @var Route */
    protected $route;

    /** @var Container */
    protected $container;

    /** @var \stdClass 返回内容 */
    protected $data;

    public function __construct(Slim $app, $container, Route $route) {
        $this->app = $app;
        $this->container = $container;
        $this->route = $route;
        $this->data = new \stdClass();
    }

    public function setResponse($key, $value) {
        $this->data->$key = $value;
    }

    public function getResponse($key) {
        return isset($this->data->$key) ? $this->data->$key : null;
    }

    public function response($code, $msg = '') {
        echo json_encode([
            'code' => $code,
            'msg'  => $msg,
            'data' => $this->data,
        ]);
        die;
    }

    /**
     * 根据header中的内容校验请求
     */
    public function checkToken() {
        $userId = Util::headerConf('uid');
        $timeStamp = Util::headerConf('timestamp');
        $uuid = Util::headerConf('uuid');
        //任何参数没有设置或timestamp与当前时间相差五分钟以上则失败
        if ($userId == null || $timeStamp == null || $uuid == null || time() - intval($timeStamp) > 300) {
            $this->response(-1, '请求错误');
        }
        global $container;
        /** @var UserService $userService */
        $userService = $container['user'];
        $user = $userService->getUserById($userId);
        //user_id不存在
        if ($user === false) {
            $this->response(406, '请求错误');
        }
        $token = $user['token'];
        //校验
        if ($uuid != md5($userId . $token . $timeStamp)) {
            $this->response(406, '请求错误');
        }
    }
}