<?php
namespace EventsdWeb\Models;
use \FourOneOne\ActiveRecord\ActiveRecord;

class ExternalAccountMeta extends ActiveRecord{
  protected $_table = "external_account_metas";

  public $external_account_meta_id;
  public $external_account_id;
  public $key;
  public $value;
  public $created;
  public $is_json = 0;

}