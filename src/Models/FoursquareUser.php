<?php
namespace EventsdWeb\Models;
use Eventsd\Eventsd;
use Eventsd\Models\Application;
use Eventsd\Models\Occurrence;
use \FourOneOne\ActiveRecord\ActiveRecord;

class FoursquareUser extends ActiveRecord{
  protected $_table = "foursquare_users";

  public $foursquare_user_id;
  public $id;
  public $first_name;
  public $last_name;
  public $gender;
  public $relationship;
  public $photo;
  public $event_time;

  public function trigger_event(){
    $this->event_time = date("Y-m-d H:i:s");
    Eventsd::trigger('foursquare.friend_found', $this->__toJson());
    $this->save();
  }

}

