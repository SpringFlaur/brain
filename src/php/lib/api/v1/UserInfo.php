<?php

namespace brain\api\v1;


use brain\frame\Controller;
use brain\service\user\UserService;

//处理用户信息接口
class UserInfo extends Controller {
    public function postAction() {
        $this->checkToken();
        $userId = $this->app->request->post('user_id');
        global $container;
        /** @var UserService $userService */
        $userService = $container['user'];
        $userInfo = $userService->getUserById($userId);
        if (!$userInfo) {
            $this->response(406, '用户信息错误');
        }

        //检查post参数中设置了哪些信息，并进行更新
        foreach ($userInfo as $key => $value) {
            if ($key == 'user_id') { //user_id无法更改
                continue;
            }
            if ($this->app->request->post($key)) {
                $userInfo[$key] = $this->app->request->post($key);
            }
        }

        $rs = $userService->updateUser($userInfo, $userId);
        if ($rs) {
            foreach ($userInfo as $key => $value) {
                $this->setResponse($key, $value);
            }
            $this->response(0, '更新成功');
        }
        $this->response(-1, '更新失败');
    }
}