<?php
use Eventsd\Models\User;
use EventsdWeb\Models\ExternalAccount;
use EventsdWeb\Models\ExternalAccountType;

$app->get('/options/external-accounts', function () use ($app) {
  User::check_logged_in();
  $user = User::get_current();
  $app->render('options/external.phtml', array(
    'accounts' => ExternalAccount::search()->where('user_id', $user->user_id)->exec()
  ));
});

$app->get('/options/external-accounts/new', function () use ($app) {
  User::check_logged_in();
  $app->render('options/external.wizard.choose-service.phtml', array(
    'services' => ExternalAccountType::search()->exec()
  ));
});

$app->post('/options/external-accounts/connect', function () use ($app) {
  User::check_logged_in();

  $external_account_type = ExternalAccountType::search()->where('external_account_type_id', $app->request()->post('service'))->execOne();

  if($external_account_type->name == 'Google Drive'){
    header("Location: " . $app->view()->url("options/external-accounts/connect/google-drive"));
    exit;
  }

  if($external_account_type->name == 'Foursquare'){
    header("Location: " . $app->view()->url("options/external-accounts/connect/foursquare"));
    exit;
  }
  exit;
});

$app->get('/options/external-accounts/remove/:account_id', function ($account_id) use ($app) {
  User::check_logged_in();

  $external_account= ExternalAccount::search()->where('external_account_id', $account_id)->execOne();
  $external_account->delete();

  header("Location: " . $app->view()->url("options/external-accounts"));
  exit;
});

$app->get('/options/external-accounts/:account_id/inventory/run', function ($account_id) use ($app) {
  User::check_logged_in();

  $external_account= ExternalAccount::search()->where('external_account_id', $account_id)->execOne();
  $external_account->inventory();

  header("Location: " . $app->view()->url("options/external-accounts"));
  exit;
});

$app->get('/options/external-accounts/:account_id/inventory/list', function ($account_id) use ($app) {
  User::check_logged_in();
  $app->render('options/external.inventory.phtml', array(
  ));
});

$app->get('/options/external-accounts/check-for-events/:account_id/', function ($account_id) use ($app) {
  User::check_logged_in();
  $external_account= ExternalAccount::search()
    ->where('external_account_id', $account_id)
    ->where('user_id', User::get_current()->user_id)
    ->execOne();
  $external_account->check_for_events();
  exit;
});
