<?php
require_once("bootstrap.php");

use \EventsdWeb\Models\ExternalAccount;

foreach(ExternalAccount::get_all() as $external_account){
  /* @var $external_account ExternalAccount */
  echo "Check for Events on {$external_account->get_firstname()} {$external_account->get_lastname()} (#{$external_account->external_account_id})\n";
  if(method_exists($external_account, 'check_for_events')){
    try{
      $external_account->check_for_events();
      echo " > Done\n";
    }catch(Exception $e){
      echo " > " . $e->getMessage()."\n";
    }
  }
  echo "\n";
}