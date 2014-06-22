<?php
use Ratchet\Server\IoServer;
use EventsdWeb\RealtimeUpdate;

require dirname(__FILE__) . '/vendor/autoload.php';

$server = IoServer::factory(
  new RealtimeUpdate(),
  8080
);

$server->run();