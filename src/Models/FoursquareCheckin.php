<?php
namespace EventsdWeb\Models;
use Eventsd\Eventsd;
use Eventsd\Models\Application;
use Eventsd\Models\Occurrence;
use \FourOneOne\ActiveRecord\ActiveRecord;

class FoursquareCheckin extends ActiveRecord{
  protected $_table = "foursquare_checkins";

  public $foursquare_checkin_id;
  public $id;
  public $created_at;
  public $type;
  public $timezone_offset;
  public $foursquare_venue_id;
  public $foursquare_user_id;
  public $source;
  public $sticker;
  public $event_time;

  public function trigger_event(){
    $this->event_time = date("Y-m-d H:i:s");
    Eventsd::trigger('foursquare.checkin', $this->__toJson());
    $this->save();
  }

}

