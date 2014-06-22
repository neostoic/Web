<?php
use Eventsd\Models\User;
use EventsdWeb\Auth;
use EventsdWeb\Models\ExternalAccount;
use EventsdWeb\Models\ExternalAccountType;
use EventsdWeb\Models\ExternalAccountMeta;

$app->get('/options/external-accounts/connect/foursquare', function () use ($app) {
  list($client, $redirector, $factory, $auth) = Auth::get_foursquare_auth();
  $auth->initiateLogin();
  exit;
});

$app->get('/options/external-accounts/connect/google-drive/callback', function () use ($app) {
  $gClient = Auth::get_google_auth();
  $gClient->authenticate($app->request()->get('code'));

  $account = new ExternalAccount();
  $external_account_type = ExternalAccountType::search()->where('name', "Google Drive")->execOne();
  $account->external_account_type_id = $external_account_type->external_account_type_id;
  $account->token = $gClient->getAccessToken();
  $account->user_id = User::get_current()->user_id;
  $account->created = date("Y-m-d H:i:s");
  $account->save();

  $google_oauthV2 = new Google_Service_Oauth2($gClient);
  $identity = $google_oauthV2->userinfo_v2_me->get();

  foreach((array)$identity as $key => $value){
    $meta = new ExternalAccountMeta();
    $meta->created = date("Y-m-d H:i:s");
    $meta->external_account_id = $account->external_account_id;
    $meta->key = $key;
    if(is_object($value) || is_array($value)){
      $meta->value = json_encode($value);
      $meta->is_json = 1;
    }else{
      $meta->value = $value;
    }
    $meta->save();
  }
  header('Location: ' . $app->view()->url("/options/external-accounts"));
  exit;
});
