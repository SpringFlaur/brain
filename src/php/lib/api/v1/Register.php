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
        $nick = $this->app->request->post('nick');
        $gender = $this->app->request->post('gender');
        $description = $this->app->request->post('description');
        /** @var UserService $userService */
        $userService = $container['user'];
        $rs = $userService->register($email, $password, $nick, $gender, $description);
        if ($rs === false) {
            $code = -1;
            $msg = '用户已存在';
            $this->response($code, $msg);
        }
        $user = $userService->getUserByemail($email);
        $this->setResponse('user_id', $user['user_id']);
        $this->setResponse('token', $user['token']);
        $this->setResponse('nick', $user['nick']);
        $this->setResponse('gender', $user['gender']);
        $this->setResponse('description', $user['description']);
        $this->response(0, '注册成功');
    }
}