<?php
use Eventsd\Models\User;

$app->get('/status', function () use ($app) {
  User::check_logged_in();

  exec("ps auxwww|grep eventsd.daemon.php|grep -v grep", $udp);
  exec("ps auxwww|grep realtime.js|grep -v grep", $nodejs);

  $status = array(
    'udp' => (strlen(end($udp)) > 0)?'OKAY':'FAILED',
    'nodejs' => (strlen(end($nodejs)) > 0)?'OKAY':'FAILED',
  );


  $app->render('status/status.phtml', $status);
});

