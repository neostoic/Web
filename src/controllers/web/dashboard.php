<?php
use Eventsd\Models\User;

$app->get('/dashboard', function () use ($app) {

  User::check_logged_in();

  $app->render('dashboard/dashboard.phtml', array());
});
