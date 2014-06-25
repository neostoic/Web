<?php
namespace EventsdWeb\Models;

use EventsdWeb\Auth;

class FoursquareExternalAccount extends ExternalAccount{
  public function __requires_recast(){
    return false;
  }

  public function get_firstname(){
    return $this->get_metas('firstName')->value;
  }

  public function get_lastname(){
    return $this->get_metas('lastName')->value;
  }

  public function get_email(){
    $contact = $this->get_metas('contact');
    $deserialise = json_decode($contact->value);
    return $deserialise->email;
  }

  public function check_for_events(){
    /**
     * @var $client \TheTwelve\Foursquare\HttpClient\CurlHttpClient
     * @var $redirector \TheTwelve\Foursquare\Redirector\HeaderRedirector
     * @var $factory \TheTwelve\Foursquare\ApiGatewayFactory
     * @var $auth \TheTwelve\Foursquare\AuthenticationGateway
     */
    list($client, $redirector, $factory, $auth) = Auth::get_foursquare_auth();
    $factory->setToken($this->token);
    $checkin_gateway = $factory->getUsersGateway();
    $checkins = $checkin_gateway->getCheckins(array('limit' => 250));
    $badges = $checkin_gateway->getBadges(array('limit' => 250));
    $mayorships = $checkin_gateway->getMayorships(array('limit' => 250));

    foreach($checkins as $checkin){
      /**
       * @var $oVenue FoursquareVenue
       * @var $oCheckin FoursquareCheckin
       */
      $oVenue = FoursquareVenue::search()->where('id', $checkin->venue->id)->execOne();
      if(!$oVenue){
        $oVenue = new FoursquareVenue();
        $oVenue->id         = $checkin->venue->id;
        $oVenue->name       = $checkin->venue->name;
        $oVenue->latitude   = $checkin->venue->location->lat;
        $oVenue->longitude  = $checkin->venue->location->lng;
        $oVenue->cc         = $checkin->venue->location->cc;
        $oVenue->city       = $checkin->venue->location->city;
        $oVenue->state      = $checkin->venue->location->state;
        $oVenue->country    = $checkin->venue->location->country;
        $oVenue->save();
      }
      $oCheckin = FoursquareCheckin::search()->where('id', $checkin->id)->execOne();
      if(!$oCheckin){
        $oCheckin = new FoursquareCheckin();
        $oCheckin->id = $checkin->id;
        $oCheckin->created_at = date("Y-m-d H:i:s", $checkin->createdAt);
        $oCheckin->type = $checkin->type;
        $oCheckin->timezone_offset = $checkin->timeZoneOffset;
        $oCheckin->foursquare_venue_id = $oVenue->foursquare_venue_id;
        $oCheckin->source = $checkin->source->name;
        $oCheckin->save();
      }
    }
    \Kint::dump($checkins, $badges, $mayorships);
  }
}