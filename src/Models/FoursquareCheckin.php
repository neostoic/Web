<?php
namespace EventsdWeb\Models;
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
  public $event_time;
  public $source;

}

