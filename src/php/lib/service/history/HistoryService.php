<?php

namespace brain\service\history;

use Medoo\Medoo;

class HistoryService {

    /** @var Medoo */
    private $db;

    public function __construct(Medoo $db) {
        $this->db = $db;
    }

    /**
     * 查询历史事件
     * @param $date
     * @return array|bool
     */
    public function getHistoryByDate($date) {
        $rs = $this->db->select('history_context', '*', [
            'date[=]' => $date,
        ]);
        if (is_array($rs)) {
            return $rs;
        } else {
            return [];
        }
    }

    /**
     * 插入历史事件
     * @param $data
     * @return bool|\PDOStatement
     */
    public function saveHistory($data) {
        $rs = $this->db->insert('history_context', $data);
        return $rs;
    }
}