<?php
namespace EventsdWeb\Models;

use EventsdWeb\Auth;

class GoogleDriveExternalAccount extends ExternalAccount{
  public function __requires_recast(){
    return false;
  }

  public function inventory(){
    ini_set('memory_limit', '512M');

    $gClient = Auth::get_google_auth();
    $gClient->setAccessToken($this->token);
    $gDrive = new \Google_Service_Drive($gClient);
    $page_token = null;
    $files = array();
    do{
      try{
        $found_files = $gDrive->files->listFiles(array('pageToken' => $page_token));
        $files = array_merge($files, $found_files->getItems());
        $page_token = $found_files->getNextPageToken();
      }catch(\Exception $e){
        throw $e;
      }
    }while($page_token && 1==2);

    foreach($files as $file){
      echo "<pre>"; var_dump($file);exit;
    }
  }
}