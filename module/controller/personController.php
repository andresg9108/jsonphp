<?php

namespace module\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal};
use model\{connection, systemException};
use model\appRegistration\appRegistrationProxy;

class personController extends controller {

  private static $instance;

  /*
  */
  public function updateAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $oResponse = appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
      if($oResponse->status != 1){ return $oResponse; }
      // END APP VALIDATION

      // BEGIN VALIDATE SESSION
      $sCode = (!empty($post->code)) ? $post->code : '';
      $oObject = Useful::getDecodeJWT($sCode);
      $iId = (!empty($oObject->id)) ? $oObject->id : null;
      $iProfile = (!empty($oObject->profile)) ? $oObject->profile : null;
      // BEGIN VALIDATE SESSION

      // BEGIN CAPTCHA VALIDATION
      $sResponse = (!empty($post->response)) ? $post->response : '';
      $bReCaptcha = Useful::getStatusReCaptcha($sResponse);
      if(!$bReCaptcha){
        throw new systemException(constantGlobal::getConstant('FAIL_CAPTCHA'));
      }
      // END CAPTCHA VALIDATION

      $sName = (!empty($post->name)) ? $post->name : '';
      $sLastName = (!empty($post->last_name)) ? $post->last_name : '';

      $sName = Useful::getFilterCharacters($sName);
      $sLastName = Useful::getFilterCharacters($sLastName);

      return Useful::getResponseArray(1, (object)[], 'ID User: '.$iId.' ID Profile: '.$iProfile, $sCode);
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
