<?php
namespace EventsdWeb\Models;
use Eventsd\Models\Application;
use Eventsd\Models\Occurrence;
use Eventsd\Eventsd;
use \FourOneOne\ActiveRecord\ActiveRecord;

class FoursquareVenue extends ActiveRecord{
  protected $_table = "foursquare_venues";

  public $foursquare_venue_id;
  public $id;
  public $name;
  public $latitude;
  public $longitude;
  public $cc;
  public $city;
  public $state;
  public $country;

  public function trigger_event(){
    $this->event_time = date("Y-m-d H:i:s");
    echo " > foursquare.new_venue: New Venue Found\n";
    Eventsd::trigger('foursquare.new_venue', $this->__toJson());
    $this->save();
  }

}

