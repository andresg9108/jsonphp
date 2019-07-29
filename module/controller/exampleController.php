<?php

namespace module\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal, systemException};
use andresg9108\connectiondb\connection;
use model\appRegistration\appRegistrationProxy;

class exampleController extends controller {

  private static $instance;

  /*
  */
  public function exampleAction($get, $post){
    // throw new systemException("System exception.", 1);
    
    return ['Hello World'];
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
