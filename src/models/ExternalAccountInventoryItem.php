<?php
namespace EventsdWeb\Models;
use \FourOneOne\ActiveRecord\ActiveRecord;

class ExternalAccountInventoryItem extends ActiveRecord{
  protected $_table = "external_account_inventory_items";

  public $external_account_inventory_item_id;
  public $external_account_id;


}