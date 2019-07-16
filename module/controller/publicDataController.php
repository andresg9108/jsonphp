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
    try {
      return appRegistrationProxy::save((object)[]);
    } catch (systemException $e) {
      return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), $e->getMessage());
    } catch (ExpiredException $e) {
      return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
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
