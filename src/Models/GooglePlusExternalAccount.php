<?php
namespace EventsdWeb\Models;

use EventsdWeb\Auth;

class GooglePlusExternalAccount extends ExternalAccount{
  public function __requires_recast(){
    return false;
  }

  public function inventory(){
    ini_set('memory_limit', '512M');

    $gClient = Auth::get_google_auth();
    $gClient->setAccessToken($this->token);
    $gPlus = new \Google_Service_Plus($gClient);

  }
}