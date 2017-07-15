# monitor-api


**host_config.php**
主域名配置文件

**api_config.php**
接口配置文件

**code_config.php**
根据接口返回状态码分类

**user_config.php**
用户登录的配置信息文件

**wx_config.php**
微信企业号的配置文件，用来接收报警信息用

**CurlConnect.php**
网络请求类

**wxchat.php**
微信企业号操作类

**monitor.php**
监控主程序文件

**show.php**
web版查看页

**run_monitor_api.sh**
放在linux的计划任务使用,
例如（5分钟监控一次）：
*/5  *  *  *  * root /bin/sh /data/api/run_monitor_api.sh

**access_token.log**
用来记录微信企业号的access_token


