<?php
/**
 * User: hamdon
 * Date: 2017/7/14
 * Time: 14:32
 */

return [
    /**
     * 微信企业号的corpid,在管理后台可查看到
     * 微信企业号的secret,在管理后台可查看到
     */
    'wx_get_token'=>['corpid'=>'xxxxxbbbcccddd','corpsecret'=>'abcd_dfasfasfasfasf_dfafasdfasdfasdfasfa_dfadsfadsfdfdferfefeffefe'],

    /**
     * 微信企业号的agentid，对应应用的id,可在后台查看到
     */
    'agent_id'=>2,

    /**
     * 获取微信企业号token的地址
     */
    'token_url'=>'https://qyapi.weixin.qq.com/cgi-bin/gettoken',

    /**
     * 微信企业号发信息的地址
     */
    'send_message_url'=>'https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={token}'
];