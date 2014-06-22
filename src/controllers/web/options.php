<?php
use Eventsd\Models\User;

$app->get('/options', function () use ($app) {
  User::check_logged_in();
  $app->render('options/my-account.phtml', array());
});

$app->get('/options/privacy', function () use ($app) {
  User::check_logged_in();
  $app->render('options/privacy.phtml', array());
});
