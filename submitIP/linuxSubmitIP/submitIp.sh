#!/bin/bash
#curl -A"Mozilla/4.0" -b"__test=6237ccb567fe8056a2c63c7608899a01" http://ericlin.nichesite.org/keyvalueDB.php?method=set&key=ailab-linux-ip&value=`ifconfig |grep inet|head -n1|awk -F' ' '{print $2}'|awk -F':' '{print $2}'``ifconfig |grep inet|head -n1|awk -F' ' '{print $2}'|awk -F':' '{print $2}'`
cook="__test=6237ccb567fe8056a2c63c7608899a01"
ip=`ifconfig |grep inet|head -n1|awk -F' ' '{print $2}'|awk -F':' '{print $2}'`
echo ip=$ip
req="http://ericlin.nichesite.org/keyvalueDB.php?method=set&key=ailab-linux-ip&value="$ip

curl -A"Mozilla/4.0" -b $cook $req
