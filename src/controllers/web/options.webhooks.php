<?php
use Eventsd\Models\User;
use EventsdWeb\Models\ExternalAccount;
use EventsdWeb\Models\ExternalAccountType;

$app->get('/options/webhooks', function () use ($app) {
  User::check_logged_in();
  $user = User::get_current();
  $app->render('options/webhooks.phtml', array(
    'webhooks' => \EventsdWeb\Models\ExternalWebhook::search()->where('user_id', $user->user_id)->exec(),
  ));
});

$app->get('/options/webhooks/new', function () use ($app) {
  User::check_logged_in();
  $user = User::get_current();
  $app->render('options/new-webhook.phtml', array(
    'applications' => \Eventsd\Models\Application::search()->where('user_id', $user->user_id)->exec(),
  ));
});

$app->post('/options/webhooks/new', function () use ($app) {
  User::check_logged_in();
  $user = User::get_current();
  $webhook = new \EventsdWeb\Models\ExternalWebhook();
  $webhook->name = $app->request->post('name');
  $webhook->key = \FourOneOne\ActiveRecord\UUID::v4();
  $webhook->user_id = $user->user_id;
  $webhook->application_id = $app->request->post('application_id');
  $webhook->save();

  header('Location: ' . $app->view()->url("/options/webhooks"));
  exit;
});

$app->get('/options/webhooks/remove/:webhook_id', function ($webhook_id) use ($app) {
  User::check_logged_in();
  $user = User::get_current();
  $webhook_to_delete = \EventsdWeb\Models\ExternalWebhook::search()
    ->where('user_id', $user->user_id)
    ->where('external_webhook_id', $webhook_id)
    ->execOne();
  if($webhook_to_delete instanceof \EventsdWeb\Models\ExternalWebhook){
    $webhook_to_delete->delete();
  }

  header('Location: ' . $app->view()->url("/options/webhooks"));
  exit;
});

$app->post("/webhook/:webhook_uuid", function($webhook_uuid) use ($app){
  $webhook = \EventsdWeb\Models\ExternalWebhook::search()
    ->where('key', $webhook_uuid)
    ->execOne();
  if($webhook instanceof \EventsdWeb\Models\ExternalWebhook){
    $webhook->trigger($app->request()->post(), $_SERVER['REMOTE_ADDR']);
    die("OKAY");
  }else{
    die("No such webhook");
  }
  exit;
});

$app->get("/webhook/:webhook_uuid", function($webhook_uuid) use ($app){
  $webhook = \EventsdWeb\Models\ExternalWebhook::search()
    ->where('key', $webhook_uuid)
    ->execOne();
  if($webhook instanceof \EventsdWeb\Models\ExternalWebhook){
    $webhook->trigger($app->request()->get(), $_SERVER['REMOTE_ADDR']);
    die("OKAY");
  }else{
    die("No such webhook");
  }
  exit;
});