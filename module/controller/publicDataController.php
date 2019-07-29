<?php

namespace module\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal, systemException};
use andresg9108\connectiondb\connection;
use model\appRegistration\appRegistrationProxy;

class publicDataController extends controller {

  private static $instance;

  /*
  */
  public function getRegCodeAction($get, $post){
    $oResponse = appRegistrationProxy::save((object)[]);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
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
