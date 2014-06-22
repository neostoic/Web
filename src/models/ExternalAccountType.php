<?php
namespace EventsdWeb\Models;
use \FourOneOne\ActiveRecord\ActiveRecord;

class ExternalAccountType extends ActiveRecord{
  protected $_table = "external_account_types";

  public $external_account_type_id;
  public $name;

}