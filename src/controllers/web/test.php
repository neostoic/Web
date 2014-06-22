<?php
use Eventsd\Models\User;

$app->get('/loadtest', function () use ($app) {

  \Eventsd\Eventsd::trigger("loadtest", json_encode(array('url'=>$_SERVER['REQUEST_URI'], 'delay' => microtime(true) - TIME_STARTUP)));

});
