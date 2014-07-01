<?php

$app->get('/status', function () use ($app) {

  exec("ps auxwww|grep eventsd.daemon.php|grep -v grep", $udp);
  exec("ps auxwww|grep realtime.js|grep -v grep", $nodejs);

  $status = array(
    'udp' => (strlen(end($udp)) > 0)?'OKAY':'FAILED',
    'nodejs' => (strlen(end($nodejs)) > 0)?'OKAY':'FAILED',
  );

  $app->view()->addJS(WEB_ROOT . "/themes/Eventsd" . "/js/status.js");
  $app->view()->addJS(WEB_ROOT . "/themes/Eventsd" . "/highcharts/js/modules/solid-gauge.src.js");


  $app->render('status/status.phtml', $status);
});

