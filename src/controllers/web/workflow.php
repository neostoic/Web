<?php

$app->get('/workflow/create', function () use ($app) {

  \Eventsd\Models\User::check_logged_in();
  $user = \Eventsd\Models\User::get_current();
  $distinct_events = \FourOneOne\ActiveRecord\DatabaseLayer::get_instance()->passthru('SELECT DISTINCT `event` FROM occurrences WHERE user_id = ' . $user->user_id)->execute();


  foreach($distinct_events as $distinct_event){
    $event_name = $distinct_event->event;
    $events[] = \Eventsd\Models\Occurrence::search()
      ->where('event', $event_name)
      ->where('user_id', $user->user_id)
      ->order('local_time', 'DESC')
      ->execOne();
  }

  $app->render('workflow/creator.phtml', array(
    'events' => $events
  ));
});

