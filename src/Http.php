<?php

namespace Youxiage\Http;

class Http
{

    /**
     * 获取客户端IP
     * @return string
     */
    public static function getIp()
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
     * @param $url string 请求的url地址
     * @param array $data 发送的post数据 如果为空则为get方式请求
     * @param array $header http发送header信息
     * @param int $timeout 超时时间/秒，默认2秒超时
     * @return bool|string 请求后获取到的数据
     */
    public static function curlRequest($url, $data = array(), $header = array(), $timeout = 2) {
        $ch = curl_init();
        //请求url地址
        $params[CURLOPT_URL] = $url;
        //是否返回响应头信息
        $params[CURLOPT_HEADER] = false;
        //是否将结果返回
        $params[CURLOPT_RETURNTRANSFER] = true;
        //是否重定向
        $params[CURLOPT_FOLLOWLOCATION] = true;
        //超时时间
        $params[CURLOPT_TIMEOUT] = $timeout;
        //有参数为post请求
        if (!empty($data)) {
            $params[CURLOPT_POST] = true;
            $params[CURLOPT_POSTFIELDS] = $data;
        }
        //请求https时设置,还有其他解决方案
        if (stripos($url, 'https') !== false) {
            $params[CURLOPT_SSL_VERIFYPEER] = false;
            $params[CURLOPT_SSL_VERIFYHOST] = false;
        }
        //header头信息
        if (!empty($header)) {
            $params[CURLOPT_HTTPHEADER] = $header;
        }
        //是否返回Header区域内容。0：不返回
        $params[CURLOPT_HEADER] = 0;
        //传入curl参数
        curl_setopt_array($ch, $params);
        //执行
        $content = curl_exec($ch);
        //关闭连接
        curl_close($ch);

        return $content;
    }
}