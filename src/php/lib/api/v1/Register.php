<?php

namespace brain\api\v1;

use brain\frame\Controller;
use brain\service\user\UserService;

//注册接口
class Register extends Controller {
    public function postAction() {
        global $container;
        $email = $this->app->request->post('email');
        $password = $this->app->request->post('password');
        /** @var UserService $userService */
        $userService = $container['user'];
        $rs = $userService->register($email, $password);
        $code = 0;
        $msg = '注册成功';
        if ($rs === false) {
            $code = -1;
            $msg = '用户已存在';
        }
        $data = new \stdClass();
        if ($code === 0) {
            $user = $userService->getUserByemail($email);
            $data->user_id = $user['user_id'];
            $data->token = $user['token'];
        }
        $this->response($code, $msg, $data);
    }
}