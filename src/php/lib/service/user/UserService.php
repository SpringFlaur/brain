<?php

namespace brain\service\user;


use Medoo\Medoo;

class UserService {

    /** @var Medoo */
    private $db;

    public function __construct(Medoo $db) {
        $this->db = $db;
    }

}