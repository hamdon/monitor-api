<?php
/**
 * User: hamdon
 * Date: 2017/7/14
 * Time: 18:26
 */
return [
    /**
     * 查找login_url里面的点位符
     */
    'login_url_replace_search'=>['{account}','{pwd}'],

    /**
     * 替换login_url里面的点位符
     */
    'login_url_replace_replace'=>['account','password'],

    /**
     * 登录系统的url
     */
    'login_url'=>'/your/login?phone={account}&password={pwd}',

    /**
     * 账号,跟login_url_replace_replace里面的对应
     */
    'account'=>'hamdon',

    /**
     * 密码跟login_url_replace_replace里面的对应
     */
    'password'=>'agoodman'
];