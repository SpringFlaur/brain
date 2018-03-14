<?php

namespace brain\service\user;


use Medoo\Medoo;

class UserService {

    /** @var Medoo */
    private $db;

    public function __construct(Medoo $db) {
        $this->db = $db;
    }

    //用户已注册
    public function userExist($email) {
        $rs = $this->db->select('users', [], '*', [
            'email[=]' => $email,
        ]);
        if (is_array($rs) && !empty($rs)) {
            return true;
        } else {
            return false;
        }
    }

    //用户注册
    public function register($email, $password) {
        if ($this->userExist($email)) {
            return false;
        } else {
            $rs = $this->db->insert('users', [
                'email' => $email,
                'password' => $password,
                'reg_time' => date("Y-m-d H:i:s", time()),
                'token' => md5($email . time()),
            ]);
            return $rs;
        }
    }

}