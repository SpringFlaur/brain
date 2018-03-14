<?php

namespace brain\frame;

use brain\service\user\UserService;
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

    //校验请求
    public function checkToken($usePost = false) {
        $userId = $usePost ? $this->app->request->post('user_id') : $this->app->request->get('user_id');
        $timeStamp = $usePost ? $this->app->request->post('time_stamp') : $this->app->request->get('time_stamp');
        $uuid = $usePost ? $this->app->request->post('uuid') : $this->app->request->get('uuid');
        //任何参数没有设置或timestamp与当前时间相差两秒以上则失败
        if ($userId == null || $timeStamp == null || $uuid == null || time() - intval($uuid) > 2) {
            $this->response(-1, '请求错误');
        }
        global $container;
        /** @var UserService $userService */
        $userService = $container['user'];
        $user = $userService->getUserById($userId);
        //user_id不存在
        if ($user === false) {
            $this->response(-1, '请求错误');
        }
        $token = $user['token'];
        //校验
        if ($uuid != md5($userId . $token . $timeStamp)) {
            $this->response(-1, '请求错误');
        }
    }
}