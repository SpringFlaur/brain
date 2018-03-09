<?php

namespace brain\api\v1;

use brain\frame\Controller;
use Medoo\Medoo;

//注册接口
class Register extends Controller {
    public function postAction() {
        global $container;
        /** @var Medoo $db */
        $db = $container['db'];
        $email = $this->app->request->post('email');
        $password = $this->app->request->post('password');
        $rs = $db->insert('users', [
            'email' => $email,
            'password' => $password,
        ]);
        file_put_contents('e:/log.txt', var_export($rs, true));
        $this->response(0, '', [
            'email' => $email,
            'password' => $password,
        ]);
    }
}