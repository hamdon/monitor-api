#!/bin/sh
#
#  monitor api
#set -e
#set -x

ret=`ps aux | grep monitor.php | grep -v grep`
if [ -z "$ret" ]
then
/usr/sbin/php /data/api/monitor.php &
fi

