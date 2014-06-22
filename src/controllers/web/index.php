<?php

use Eventsd\Models\User;

$app->get('/', function () use ($app) {
  $app->render('home/home.phtml', array(
  ));
});
