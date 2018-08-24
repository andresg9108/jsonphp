<?php

namespace administration\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Util\{Util, constantGlobal};
use model\appRegistration\appRegistrationProxy;

class publicDataController extends controller {

  private static $instance;

  /*
  */
  public function getRegCodeAction($get, $post){
    try {
      $oAppRegistration = [];
      $oAppRegistration = (object)$oAppRegistration;
      $aResponse = appRegistrationProxy::save($oAppRegistration);
      return $aResponse;
    } catch (ExpiredException $e) {
      return $oResponse = Util::getResponseArray(false, (object)[]
        ,'', constantGlobal::ERROR_SESSION);
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(false, (object)[]
        ,'', constantGlobal::ERROR_404);
    }
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
