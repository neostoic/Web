<?php
use Eventsd\Models\User;

$app->get('/apps', function () use ($app) {

  User::check_logged_in();

  $app->render('applications/myapplications.phtml', array(
    'applications' => \Eventsd\Models\Application::search()
        ->where('user_id', User::get_current()->user_id)
        ->exec()
  ));
});
