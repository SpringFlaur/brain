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
    public function getUserByemail($email) {
        $rs = $this->db->select('users', '*', [
            'email[=]' => $email,
        ]);
        if (is_array($rs) && !empty($rs)) {
            return $rs[0];
        } else {
            return false;
        }
    }

    public function getUserById($userId) {
        $rs = $this->db->select('users', '*', [
            'user_id[=]' => $userId,
        ]);
        if (is_array($rs) && !empty($rs)) {
            return $rs[0];
        } else {
            return false;
        }
    }

    //用户注册
    public function register($email, $password, $nick = null, $gender = null, $description = null) {
        if ($this->getUserByemail($email)) {
            return false;
        } else {
            $user = [
                'email'    => $email,
                'password' => $password,
                'reg_time' => date("Y-m-d H:i:s", time()),
                'token'    => md5($email . time()),
            ];
            if ($nick) {
                $user['nick'] = $nick;
            }
            if ($gender) {
                $user['gender'] = $gender;
            }
            if ($description) {
                $user['description'] = $description;
            }
            $rs = $this->db->insert('users', $user);
            return $rs;
        }
    }

    //更新用户信息
    public function updateUser(array $params, $userId) {
        $this->db->update('users', $params, [
            'user_id[=]' => $userId,
        ]);
    }

}