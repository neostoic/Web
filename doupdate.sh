#!/bin/bash
cd www;
git pull;
git submodule init;
git submodule update;
php composer.phar update;
killall -9 php;
killall -9 nodejs;
php eventsd.daemon.php &
nodejs realtime.js &
echo "";
echo "";