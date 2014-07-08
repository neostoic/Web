#!/bin/bash
killall -9 php;
killall -9 nodejs;
git reset --hard HEAD;
git pull;
git submodule init;
git submodule update;
php composer.phar update;
nodejs realtime.js &
php eventsd.daemon.php &
php eventsd.packet-processor.php &
echo "";
echo "";