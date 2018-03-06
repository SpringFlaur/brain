<?php


namespace brain\api\v1;


use brain\frame\Controller;

class Login extends Controller {
    public function getAction() {
        $this->response(0, 'OK');
    }
}