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
        $rs = $userService->register($email, $password);
        $code = 0;
        $msg = '注册成功';
        if ($rs === false) {
            $code = -1;
            $msg = '用户已存在';
            $this->response($code, $msg);
        }
        $user = $userService->getUserByemail($email);
        $userInfo = [];
        if ($nick) {
            $userInfo['nick'] = $nick;
        }
        if ($gender) {
            $userInfo['gender'] = $gender;
        }
        if ($description) {
            $userInfo['description'] = $description;
        }
        if (!empty($userInfo)) {
            $userService->updateUser($userInfo, $user['user_id']);
        }
        $this->setResponse('user_id', $user['user_id']);
        $this->setResponse('token', $user['token']);
        $this->setResponse('nick', $nick);
        $this->setResponse('gender', $gender);
        $this->setResponse('description', $description);
        $this->response($code, $msg);
    }
}