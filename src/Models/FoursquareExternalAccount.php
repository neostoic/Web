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
    $checkins = $checkin_gateway->getCheckins();
    $badges = $checkin_gateway->getBadges();
    $mayorships = $checkin_gateway->getMayorships();
    Kint::dump($checkins, $badges, $mayorships);
  }
}