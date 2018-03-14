<?php


namespace brain\api\v1;


use brain\frame\Controller;
use brain\service\user\UserService;

//登陆接口
class Login extends Controller {
    public function postAction() {
        global $container;
        $email = $this->app->request->post('email');
        $password = $this->app->request->post('password');
        /** @var UserService $userService */
        $userService = $container['user'];
        $user = $userService->getUser($email);
        if ($user === false) {
            $this->response(-1, '用户不存在');
        }
        if ($password !== $user['password']) {
            $this->response(-1, '账号密码错误');
        }
        $this->response(0, '登陆成功', [
            'token' => $user['token'],
        ]);
    }
}