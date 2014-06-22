<?php
namespace EventsdWeb;

class Auth{
  /**
   * @return \Google_Client
   */
  static public function get_google_auth(){
    $gClient = new \Google_Client();
    $gClient->setApplicationName('Login to ' . APP_NAME);
    $gClient->setClientId(GOOGLE_CLIENT_ID);
    $gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
    $gClient->setRedirectUri(GOOGLE_REDIRECT_URL);
    //$gClient->setDeveloperKey(GOOGLE_DEVELOPER_KEY);
    $gClient->setScopes(array(
      'https://www.googleapis.com/auth/userinfo.profile',
      'https://www.googleapis.com/auth/userinfo.email',
      'https://www.googleapis.com/auth/drive',
      'https://picasaweb.google.com/data'
    ));
    return $gClient;
  }

  static public function get_foursquare_auth(){
    $client = new \TheTwelve\Foursquare\HttpClient\CurlHttpClient();
    $redirector = new \TheTwelve\Foursquare\Redirector\HeaderRedirector();
    $factory = new \TheTwelve\Foursquare\ApiGatewayFactory($client, $redirector);
    $factory->setClientCredentials(FOURSQUARE_ID, FOURSQUARE_SECRET);
    $factory->setEndpointUri('https://api.foursquare.com');
    $factory->useVersion(2);
    //$factory->verifiedOn(new \DateTime());
    $auth = $factory->getAuthenticationGateway(
      'https://foursquare.com/oauth2/authorize',
      'https://foursquare.com/oauth2/access_token',
      'YOUR_REDIRECT_URL'
    );

    return array($client, $redirector, $factory, $auth);
  }
}