<?php
namespace EventsdWeb\Models;

use EventsdWeb\Auth;

class GooglePlusExternalAccount extends ExternalAccount{
  public function __requires_recast(){
    return false;
  }

  public function check_for_events(){
    $gClient = Auth::get_google_auth();
    $gClient->setAccessToken($this->token);
    $gPlus = new \Google_Service_Plus($gClient);
    //$gMail = new \Google_Service_Mail // TODO: One day.
    \Kint::dump($gPlus->people->get('me'));exit;
  }

  public function get_firstname(){
    return $this->get_metas('givenName')->value;
  }

  public function get_lastname(){
    return $this->get_metas('familyName')->value;
  }

  public function get_email(){
    return $this->get_metas('email')->value;
  }
}