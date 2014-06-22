<?php
namespace EventsdWeb;

class Util{
  static public function get_load(){
    $load_array = sys_getloadavg();
    foreach($load_array as &$load_elem){
      $load_elem = number_format($load_elem, 2);
    }
    return $load_array;
  }
}