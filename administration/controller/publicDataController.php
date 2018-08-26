<?php

namespace administration\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Util\{Util, constantGlobal};
use model\systemException;
use model\appRegistration\appRegistrationProxy;

class publicDataController extends controller {

  private static $instance;

  /*
  */
  public function getRegCodeAction($get, $post){
    try {
      $oAppRegistration = [];
      $oAppRegistration = (object)$oAppRegistration;
      
      return appRegistrationProxy::save($oAppRegistration);
    } catch (systemException $e) {
      return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().') ' . $e->getMessage());
    } catch (ExpiredException $e) {
      return $oResponse = Util::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
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
