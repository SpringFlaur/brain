<?php

namespace brain\api\v1;

use brain\frame\Controller;
use brain\service\history\HistoryService;
use brain\service\Util\Util;

class HistoryDate extends Controller {

    public function getAction() {
        $date = $this->app->request->get('date');
        /** @var HistoryService $historyService */
        $historyService = $this->container['history'];
        $context = $historyService->getHistoryByDate($date);
        if (empty($context)) {
            $this->getHistory();
            $context = $historyService->getHistoryByDate($date);
        }
        var_dump($context);
    }

    protected function getHistory() {
        $url = Util::conf('historyUrl');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data, true);
        $time = date('Y-m-d H:i:s');
        $insertArr = [];
        foreach ($data as $date => $array) {
            foreach ($array as $line) {
                $insertArr[] = [
                    'date'        => $date,
                    'year'        => $line['year'] == '生日' ? '0' : $line['year'],
                    'context'     => $line['content'],
                    'create_time' => $time,
                ];
            }
        }
        /** @var HistoryService $historyService */
        $historyService = $this->container['history'];
        $historyService->saveHistory($insertArr);
    }

}