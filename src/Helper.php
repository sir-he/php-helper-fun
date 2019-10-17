<?php

namespace Youxiage\Helper;

class Helper
{
    /**
     * 判断当前系统是否为win
     * @return bool
     */
    public static function isWin() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        }
        return false;
    }

    /**
     * 临时记录日志
     * @param string|array $log
     */
    public static function writeLog($log = "") {
        $logFile = './tmp.log';
        file_put_contents($logFile, date("Y-m-d H:i:s", time()) . ' ' . var_export($log, true) . PHP_EOL, FILE_APPEND);
    }

    /**
     * 数据类型强制转换
     */
    public function setValueType($data, $type = "string") {
        $this->type = $type;
        if (!is_array($data)) {
            $this->_setValString($data);
        } else {
            array_walk_recursive($data, array($this, '_setValString'));
        }
        return $data;
    }

    private function _setValString(&$value) {
        settype($value, $this->type);
    }

    /**
     * -------------------------------------------
     * 二维数组按照制定的数组进行排序
     * -------------------------------------------
     * @param array $arr  二维数组
     * @param string $keys 指定排序的key
     * @param string $type asc【正序】 ｜ desc【倒序】
     * @return array
     */
    public function array_sort($arr, $keys, $type = 'asc') {
        $keysvalue = $new_array = [];
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}