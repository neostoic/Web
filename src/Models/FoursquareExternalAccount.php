<?php
namespace EventsdWeb\Models;

use EventsdWeb\Auth;

class FoursquareExternalAccount extends ExternalAccount{
  public function __requires_recast(){
    return false;
  }

}