<?php

namespace Youxiage\Helper;

class Helper
{
    /**
     * 判断当前系统是否为win
     * @return bool
     */
    public function isWin() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        }
        return false;
    }

    /**
     * 临时记录日志
     * @param string|array $log
     */
    public function writeLog($log = "") {
        $logFile = './tmp.log';
        file_put_contents($logFile, date("Y-m-d H:i:s", time()) . ' ' . var_export($log, true) . PHP_EOL, FILE_APPEND);
    }

    /**
     * 获取客户端IP
     * @return string
     */
    public function getIp()
    {
        $ip = '';
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $ip = preg_replace("/^([\d\.]+).*/", "\\1", $ip);
        return $ip;
    }

    /**
     * 数据类型强制转换
     */
    public function setValueType($data, $type = "string")
    {
        $this->type = $type;
        if (!is_array($data)) {
            $this->_setValString($data);
        } else {
            array_walk_recursive($data, array($this, '_setValString'));
        }
        return $data;
    }

    private function _setValString(&$value)
    {
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
    function array_sort($arr, $keys, $type = 'asc')
    {
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