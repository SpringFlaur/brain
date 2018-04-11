<?php

namespace brain\api\v1;

use brain\frame\Controller;
use brain\service\Util\Util;

//获取鉴权签名
class Sign extends Controller {
    public function postAction() {
        $this->checkToken();
        $tencentCloud = Util::conf('tencentCloud');
        $appid = $tencentCloud['appid'];
        $bucket = $tencentCloud['bucket'];
        $secret_id = $tencentCloud['secret_id'];
        $secret_key = $tencentCloud['secret_key'];
        $onceExpired = 0;
        $current = time();
        $rdm = rand();
        $fileid = $this->app->request->post('file_id');

        $once_signature = 'a=' . $appid . '&b=' . $bucket . '&k=' . $secret_id . '&e=' . $onceExpired . '&t=' . $current . '&r=' . $rdm . '&f=' . $fileid;
        $once_signature = base64_encode(hash_hmac('SHA1', $once_signature, $secret_key, true) . $once_signature);
        $this->setResponse('sign', $once_signature);
        $this->response(0, '');
    }
}