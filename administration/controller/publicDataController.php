<?php

namespace administration\controller;

use lib\MVC\controller;
use model\appRegistration\appRegistrationProxy;

class publicDataController extends controller {

  private static $instance;

  /*
  */
  public function getRegCodeAction($get, $post){
    $oAppRegistration = [];
    $oAppRegistration = (object)$oAppRegistration;
    $aResponse = appRegistrationProxy::save($oAppRegistration);
    return $aResponse;
  }

  /*
  */
  public static function getInstance(){
    if(static::$instance === null){
      static::$instance = new static();
    }
    return static::$instance;
  }

}

?>
