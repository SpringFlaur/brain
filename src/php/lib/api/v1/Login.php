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
        $user = $userService->getUserByemail($email);
        if ($user === false) {
            $this->response(-1, '用户不存在');
        }
        if ($password !== $user['password']) {
            $this->response(-1, '账号密码错误');
        }
        $token = md5($email . time() . $password);
        $userService->updateUser([
            'token' => $token
        ], $user['user_id']);
        $this->response(0, '登陆成功', [
            'token' => $token,
            'user_id' => $user['user_id'],
        ]);
    }
}