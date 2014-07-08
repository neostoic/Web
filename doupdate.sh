#!/bin/bash
cd www;
git reset --hard HEAD;
git pull;
git submodule init;
git submodule update;
php composer.phar update;
killall -9 php;
killall -9 nodejs;
php eventsd.daemon.php &
php eventsd.packet-processor.php &
nodejs realtime.js &
echo "";
echo "";