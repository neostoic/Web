<?php
namespace EventsdWeb\Models;
use \FourOneOne\ActiveRecord\ActiveRecord;

class ExternalAccount extends ActiveRecord{
  protected $_table = "external_accounts";

  public $external_account_id;
  public $user_id;
  public $external_account_type_id;
  public $token;
  public $created;

  private $_type;
  private $_metas;

  protected $__active_record_class;

  public function __post_construct(){
    $this->__active_record_class = "\\Skeleton\\Models\\" . str_replace(" ", "", $this->get_type()->name) . "ExternalAccount";
  }

  public function __requires_recast(){
    return true;
  }

  public function get_type(){
    if(!$this->_type){
      $this->_type = ExternalAccountType::search()->where('external_account_type_id', $this->external_account_type_id)->execOne();
    }
    return $this->_type;
  }

  public function get_metas($key = null){
    if(!$this->_metas){
      foreach(ExternalAccountMeta::search()->where('external_account_id', $this->external_account_id)->exec() as $meta){
        $this->_metas[$meta->key] = $meta;
      }
    }
    if($key){
      return $this->_metas[$key];
    }
    return $this->_metas;
  }

  public function get_firstname(){
    switch($this->get_type()->name){
      case 'Google Drive':
        return $this->get_metas('givenName')->value;
    }
  }

  public function get_lastname(){
    switch($this->get_type()->name){
      case 'Google Drive':
        return $this->get_metas('familyName')->value;
    }
  }

  public function get_email(){
    switch($this->get_type()->name){
      case 'Google Drive':
        return $this->get_metas('email')->value;
    }
  }

  public function inventory(){
    throw new \Exception("No inventory() written for " . get_called_class());
  }

  public function refresh_token(){
    $gClient = get_google_auth();
    $gClient->setAccessToken($this->token);
    // TODO work out how this works.
  }
}