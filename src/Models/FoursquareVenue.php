<?php
namespace EventsdWeb\Models;
use Eventsd\Models\Application;
use Eventsd\Models\Occurrence;
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

}

