<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use EventsdWeb\RealtimeUpdate;

require dirname(__FILE__) . '/vendor/autoload.php';

//$server = IoServer::factory(
//  new RealtimeUpdate(),
//  8080
//);

$server = IoServer::factory(
  new HttpServer(
    new WsServer(
      new RealtimeUpdate()
    )
  ),
  8080
);
$server->run();