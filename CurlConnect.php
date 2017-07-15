<?php
/**
 * User: hamdon
 * Date: 2017/6/30
 * Time: 12:30
 */


class CurlConnect
{
    var $cookie_file; // 设置Cookie文件保存路径及文件名

    /**
     * 模拟获取内容函数
     * @param $url
     * @param array $header
     * @return mixed
     */
    private  function get($url, $header=[]){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        // 对认证证书来源的检查
       // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        // 从证书中检查SSL加密算法是否存在
      //  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        // 使用自动跳转
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        // 自动设置Referer
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        // 读取上面所储存的Cookie信息
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file);
        // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);
        }
        curl_close($curl);
        return $tmpInfo;
    }

    private  function post($url,$data,$header=[]){ // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
       // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
       // curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookie_file); // 读取上面所储存的Cookie信息
        curl_setopt($curl, CURLOPT_TIMEOUT, 3); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }

    function delcookie($cookie_file){ // 删除Cookie函数
        @unlink($cookie_file); // 执行删除
    }

    public function capture($url, $method, $data, $header=[],$multi = false)
    {
        $this->cookie_file = dirname(__FILE__)."/cookie_".md5(basename(__FILE__)).".txt";
        $method = trim(strtolower($method));
        switch ($method) {
            case 'get':
                $params= http_build_query($data);
                $url=$url.'?'.$params;
                return self::get($url,$header);
                break;
            case 'post':
                $params = $multi ? $data : (is_array($data)?http_build_query($data):$data);
                $result = self::post($url, $params, $header);
                return $result;
                break;
        }
    }
}