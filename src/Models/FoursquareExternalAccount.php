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
    $checkin_gateway = $factory->getCheckinsGateway();
    $users_gateway = $factory->getUsersGateway();
    $generic_gateway = $factory->getGenericGateway();

    $checkins = $checkin_gateway->getRecent(array('limit' => 250));
    $badges       = $users_gateway->getBadges(array('limit' => 250));
    $mayorships   = $users_gateway->getMayorships(array('limit' => 250));
    $friends      = $users_gateway->getFriends();


    \Kint::dump($checkins, $badges, $mayorships, $friends);
exit;
    $this->__handle_checkins($checkins);
    // TODO: Handle Badges
    // TODO: Handle Mayorships

  }

  private function __handle_checkins($checkins){
    foreach($checkins as $checkin){
      /**
       * @var $oVenue FoursquareVenue
       * @var $oCheckin FoursquareCheckin
       */
      $oVenue = FoursquareVenue::search()->where('id', $checkin->venue->id)->execOne();

      if(!$oVenue instanceof FoursquareVenue){
        $oVenue = new FoursquareVenue();
        $oVenue->id         = $checkin->venue->id;
        $oVenue->name       = $checkin->venue->name;
        $oVenue->latitude   = isset($checkin->venue->location->lat)?$checkin->venue->location->lat:null;
        $oVenue->longitude  = isset($checkin->venue->location->lng)?$checkin->venue->location->lng:null;
        $oVenue->cc         = isset($checkin->venue->location->cc)?$checkin->venue->location->cc:null;
        $oVenue->city       = isset($checkin->venue->location->city)?$checkin->venue->location->city:null;
        $oVenue->state      = isset($checkin->venue->location->state)?$checkin->venue->location->state:null;
        $oVenue->country    = isset($checkin->venue->location->country)?$checkin->venue->location->country:null;
        $oVenue->save();
        $oVenue->trigger_event();
      }

      $oUser = FoursquareUser::search()->where('id', $checkin->user->id)->execOne();

      if(!$oUser instanceof FoursquareUser){
        $oUser = new FoursquareUser();
        $oUser->id            = $checkin->user->id;
        $oUser->first_name    = $checkin->user->firstName;
        $oUser->last_name     = $checkin->user->lastName;
        $oUser->gender        = $checkin->user->gender;
        $oUser->relationship  = $checkin->user->relationship;
        $oUser->photo         = $checkin->user->photo->prefix . $checkin->user->photo->suffix;
        $oUser->save();
      }

      $oCheckin = FoursquareCheckin::search()->where('id', $checkin->id)->execOne();

      if(!$oCheckin instanceof FoursquareCheckin){
        $oCheckin = new FoursquareCheckin();
        $oCheckin->id = $checkin->id;
        $oCheckin->created_at = date("Y-m-d H:i:s", $checkin->createdAt);
        $oCheckin->type = $checkin->type;
        $oCheckin->timezone_offset = $checkin->timeZoneOffset;
        $oCheckin->foursquare_venue_id = $oVenue->foursquare_venue_id;
        $oCheckin->foursquare_user_id = $oUser->foursquare_user_id;
        $oCheckin->source = $checkin->source->name;
        $oCheckin->sticker = isset($checkin->sticker)?$checkin->sticker:null;
        $oCheckin->save();
        $oCheckin->trigger_event();
      }
    }
  }
}