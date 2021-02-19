<?php

namespace module\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal, systemException};
use andresg9108\connectiondb\connection;
use module\constant\constantExample;

class exampleController extends controller {

  private static $instance;

  /*
  */
  public function exampleAction($get, $post){
    // throw new systemException(constantGlobal::getConstant('CONTACT_SUPPORT'));

    $sDate = date('Y-m-d H:i:s');

    $aResponse = [];
    $aResponse['test'] = constantExample::getConstant('EXAMPLE', [$sDate]);

    return Useful::getResponseArray(1, (object)$aResponse,
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
