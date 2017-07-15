<?php
/**
 * User: hamdon
 * Date: 2017/7/14
 * Time: 10:25
 */
set_time_limit(0);

include_once 'wechat.php';

$curlConnect = new CurlConnect();
$apis = require 'api_config.php';
$hosts = require 'host_config.php';
$code = require 'code_config.php';

$curlConnect = new CurlConnect();
$header[0]="xxxxx:1314";
$notify=[];
$error=[];
$status=[];
foreach ($hosts as $host){
    $data=[];
    //模拟登录
    $userInfo = require 'user_config.php';
    $replaceValue=[];
    foreach ($userInfo['login_url_replace_replace'] as  $value){
        $replaceValue[]=$userInfo[$value];
    }
    $newLoginUrl = str_replace($userInfo['login_url_replace_search'],$replaceValue,$userInfo['login_url']);
    $data = $curlConnect->capture($host.$newLoginUrl,'post',$data,$header);
    $data = json_decode($data,true);
    $header[1]='Authorization:Bearer '.$data['token'];

    foreach ($apis as $api){
        $apiUrl = $host.$api['url'];
        $result = $curlConnect->capture($apiUrl,$api['method'],[],$header);
        $result = json_decode($result,true);
        if(isset($status[$result['code']])){
            $status[$result['code']]++;
        }else{
            $status[$result['code']] = 1;
        }
        if($result['code'] && in_array($result['code'],$code['wrong'])){
            $error[]=['url'=>$apiUrl,'code'=>$result['code'],'message'=>$result['message']];
        }
        if($result['code'] && !in_array($result['code'],$code['right']) && !in_array($result['code'],$code['wrong'])){
            $notify[]=['url'=>$apiUrl,'code'=>$result['code'],'message'=>$result['message']];
        }
        sleep(1);
    }
}

echo 'End ...<br />';

echo ' 错误状态统计...<br />';
if($error) {
    foreach ($error as $key => $value) {
        echo 'code:' . $value['code'] . ',url:' . $value['url'] . ",message" . $value['message'] . "<br/>";
    }
}else {
    echo '没有数据<br/>';
}

echo '其他错误状态统计...<br />';
if($notify) {
    foreach ($notify as $key => $value) {
        echo 'code:' . $value['code'] . ',url:' . $value['url'] . ",message" . $value['message'] . "<br/>";
    }
}else {
    echo '没有数据<br/>';
}

echo ' 所有状态统计...<br />';
foreach ($status as $key=>$value) {
    echo 'code:' . $key . ',num:' . $value . "<br/>";
}

