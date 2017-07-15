<?php
/**
 * User: hamdon
 * Date: 2017/7/14
 * Time: 14:31
 */
include 'CurlConnect.php';
class WeChat{
    private $connect = null;
    private $sendMessageUrl='';
    private $agentId = 0;
    private $accessTokenFile = 'access_token.log';
    public function __construct()
    {
        $wxInfo = require 'wx_config.php';
        $accessTokenInfo = file_get_contents(__DIR__.'/'.$this->accessTokenFile);
        $accessTokens = json_decode($accessTokenInfo,true);
        $this->connect = new CurlConnect();
        if ($accessTokens['expires_at']<time()) {
            $tokens = $this->connect->capture($wxInfo['token_url'], 'get', $wxInfo['wx_get_token']);
            $token = json_decode($tokens, true);
            $accessToken = $token['access_token'];
            $fileContent['expires_at'] = time()+$token['expires_in']-10;
            $fileContent['access_token'] = $token['access_token'];
            file_put_contents(__DIR__.'/'.$this->accessTokenFile,json_encode($fileContent));
        }else {
            $accessToken = $accessTokens['access_token'];
        }
        if($accessToken){
            $this->sendMessageUrl = str_replace('{token}',$accessToken,$wxInfo['send_message_url']);
        }
        $this->agentId = $wxInfo['agent_id'];
    }

    public function send($content){
        $data['touser'] ="@all";
        $data['toparty']="";
        $data['totag']="";
        $data['msgtype']="text";
        $data["agentid"]=$this->agentId;
        $data['safe'] = "0";
        $data['text']['content'] = $content;
       return $this->connect->capture($this->sendMessageUrl,'post',json_encode($data));
    }
}