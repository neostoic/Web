<?php
use Eventsd\Models\User;

$app->get('/events/realtime', function () use ($app) {

  User::check_logged_in();

  $app->render('events/realtime.phtml', array(
    'occurrences' => \Eventsd\Models\Occurrence::search()
        ->where('user_id', User::get_current()->user_id)
        ->order('local_time', 'DESC')
        ->limit(500)->exec()
  ));
});
