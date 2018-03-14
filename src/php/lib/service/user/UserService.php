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
    public function getUser($email) {
        $rs = $this->db->select('users', '*', [
            'email[=]' => $email,
        ]);
        if (is_array($rs) && !empty($rs)) {
            return $rs[0];
        } else {
            return false;
        }
    }

    //用户注册
    public function register($email, $password) {
        if ($this->getUser($email)) {
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