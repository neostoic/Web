<?php
namespace EventsdWeb\Models;
use Eventsd\Models\Occurrence;
use \FourOneOne\ActiveRecord\ActiveRecord;

class ExternalWebhook extends ActiveRecord{
  protected $_table = "external_webhooks";

  public $external_webhook_id;
  public $user_id;
  public $name;
  public $key;

  private function get_event_name(){
    return 'Webhook.'.$this->name;
  }

  /**
   * @return Occurrence|False
   */
  public function get_last_event(){
    return Occurrence::search()->where('name', $this->get_event_name())->order('local_time', 'DESC')->execOne();
  }

  public function trigger($value, $remote_ip = null){
    $occ = new Occurrence();
    $occ->user_id = $this->user_id;
    $occ->event = $this->get_event_name();
    $occ->value = json_encode($value);
    $occ->hostname = gethostname();
    $occ->remote_ip = $remote_ip;
    $occ->local_time = date("Y-m-d H:i:s");
    $occ->remote_time = date("Y-m-d H:i:s");
    $occ->save();
  }
}

