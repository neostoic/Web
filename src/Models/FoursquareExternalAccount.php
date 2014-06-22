<?php
namespace EventsdWeb\Models;

use EventsdWeb\Auth;

class FoursquareExternalAccount extends ExternalAccount{
  public function __requires_recast(){
    return false;
  }

  public function get_firstname(){
    return $this->get_metas('firstName')->value;
  }

  public function get_lastname(){
    return $this->get_metas('lastName')->value;
  }

  public function get_email(){
    $contact = $this->get_metas('contact');
    $deserialise = json_decode($contact->value);
    var_dump($deserialise);exit;
    return $deserialise->email;
  }
}