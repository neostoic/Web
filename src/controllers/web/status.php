<?php

$app->get('/status', function () use ($app) {

  exec("ps auxwww|grep eventsd.daemon.php|grep -v grep", $udp);
  exec("ps auxwww|grep eventsd.packet-processor.php|grep -v grep", $pp);
  exec("ps auxwww|grep realtime.js|grep -v grep", $nodejs);
  exec("ps auxwww|grep redis-server|grep -v grep", $redis);

  $status = array(
    'udp' => (strlen(end($udp)) > 0)?'OKAY':'FAILED',
    'pp' => (strlen(end($pp)) > 0)?'OKAY':'FAILED',
    'nodejs' => (strlen(end($nodejs)) > 0)?'OKAY':'FAILED',
    'redis' => (strlen(end($redis)) > 0)?'OKAY':'FAILED',
  );

  if($status['redis'] == 'OKAY'){
    $redis = new \Predis\Client();
    $status['redis'] = 'OKAY. Queue: ' . $redis->llen('events_que');
  }

  $app->view()->addJS(WEB_ROOT . "/themes/Eventsd" . "/js/status.js");
  $app->view()->addJS(WEB_ROOT . "/themes/Eventsd" . "/highcharts/js/modules/solid-gauge.src.js");
  $app->view()->addJS("themes/Base/js/status.js");

  $app->render('status/status.phtml', $status);
});

