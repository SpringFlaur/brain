<?php

namespace brain\api\v1;

use brain\frame\Controller;
use brain\service\user\UserService;
use Medoo\Medoo;

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
        $msg = '';
        if ($rs === false) {
            $code = -1;
            $msg = '用户已存在';
        }
        $this->response($code, $msg);
    }
}