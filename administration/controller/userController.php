<?php

namespace administration\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal};
use model\systemException;
use model\appRegistration\appRegistrationProxy;
use model\person\personProxy;
use model\user\userProxy;

class userController extends controller {

  private static $instance;

  /*
  */
  public function sendRecoverPasswordAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      // BEGIN CAPTCHA VALIDATION
      $sResponse = (!empty($post->response)) ? $post->response : '';
      $bReCaptcha = Useful::getStatusReCaptcha($sResponse);
      if(!$bReCaptcha){
        throw new systemException(constantGlobal::getConstant('FAIL_CAPTCHA'));
      }
      // END CAPTCHA VALIDATION

      $iIdEUser = (!empty($post->ideuser)) ? $post->ideuser : null;
      $sCodeEUser = (!empty($post->codeeuser)) ? $post->codeeuser : '';
      $sPassword = (!empty($post->password)) ? $post->password : '';

      $sPassword = Useful::getFilterPassword($sPassword);

      return userProxy::sendRecoverPassword($iIdEUser, $sCodeEUser, $sPassword);
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
  public function validateRecoverPasswordAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      $iIdEUser = (!empty($post->ideuser)) ? $post->ideuser : null;
      $sCodeEUser = (!empty($post->codeeuser)) ? $post->codeeuser : '';

      return userProxy::validateRecoverPassword($iIdEUser, $sCodeEUser);
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
  public function recoverPasswordAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      // BEGIN CAPTCHA VALIDATION
      $sResponse = (!empty($post->response)) ? $post->response : '';
      $bReCaptcha = Useful::getStatusReCaptcha($sResponse);
      if(!$bReCaptcha){
        throw new systemException(constantGlobal::getConstant('FAIL_CAPTCHA'));
      }
      // END CAPTCHA VALIDATION

      $sEmail = (!empty($post->email)) ? $post->email : '';

      $sEmail = Useful::getFilterCharacters($sEmail);

      return userProxy::recoverPassword($sEmail);
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
  public function validateEmailByCodeAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      $iIdUser = (!empty($post->id_user)) ? $post->id_user : null;
      $sCodeUser = (!empty($post->code_user)) ? $post->code_user : '';

      return userProxy::validateEmailByCode($iIdUser, $sCodeUser);
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
  public function validateSessionAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      $sCode = (!empty($post->code)) ? $post->code : '';
      $oObject = Useful::getDecodeJWT($sCode);
      $iId = (!empty($oObject->id)) ? $oObject->id : null;
      $iProfile = (!empty($oObject->profile)) ? $oObject->profile : null;
      $aResponse = [];
      $aResponse['profile'] = $iProfile;

      return Useful::getResponseArray(1, (object)$aResponse, '', '');
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
  public function validateEmailAndUserAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      $sEmail = (!empty($post->email)) ? $post->email : '';
      $sUser = (!empty($post->user)) ? $post->user : '';

      return userProxy::validateEmailAndUser($sEmail, $sUser);
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
  public function logInAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      // BEGIN CAPTCHA VALIDATION
      $sResponse = (!empty($post->response)) ? $post->response : '';
      $bReCaptcha = Useful::getStatusReCaptchaHidden($sResponse);
      if(!$bReCaptcha){
        throw new systemException(constantGlobal::getConstant('FAIL_CAPTCHA'));
      }
      // END CAPTCHA VALIDATION

      $sUser = (!empty($post->user)) ? $post->user : '';
      $sPassword = (!empty($post->password)) ? $post->password : '';

      $sUser = Useful::getFilterCharacters($sUser);
      $sUser = str_replace(' ', '', $sUser);

      $aUser = [];
      $aUser['user'] = $sUser;
      $aUser['password'] = $sPassword;
      $oUser = (object)$aUser;

      return userProxy::validatelogIn($oUser);
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
  public function checkInAction($get, $post){
    try {
      // BEGIN APP VALIDATION
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      if($oResponse->status != 1){
        return $oResponse;
      }
      // END APP VALIDATION

      // BEGIN CAPTCHA VALIDATION
      $sResponse = (!empty($post->response)) ? $post->response : '';
      $bReCaptcha = Useful::getStatusReCaptcha($sResponse);
      if(!$bReCaptcha){
        throw new systemException(constantGlobal::getConstant('FAIL_CAPTCHA'));
      }
      // END CAPTCHA VALIDATION

      $sName = (!empty($post->name)) ? $post->name : '';
      $sLastName = (!empty($post->last_name)) ? $post->last_name : '';
      $sEmail = (!empty($post->email)) ? $post->email : '';
      $sUser = (!empty($post->user)) ? $post->user : '';
      $sPassword = (!empty($post->password)) ? $post->password : '';

      $sName = Useful::getFilterCharacters($sName);
      $sLastName = Useful::getFilterCharacters($sLastName);
      $sEmail = Useful::getFilterCharacters($sEmail);
      $sUser = Useful::getFilterCharacters($sUser);
      $sEmail = str_replace(' ', '', $sEmail);
      $sUser = str_replace(' ', '', $sUser);
      $sPassword = Useful::getFilterPassword($sPassword);

      $sRegistrationCode = Useful::getRandomCode();
      $aEmailUser = [];
      $aEmailUser['email'] = $sEmail;
      $aEmailUser['registration_code'] = $sRegistrationCode;
      $aEmailUser['main'] = 1;
      $aEmailUser['status'] = 0;
      $oEmailUser = (object)$aEmailUser;

      $aUser = [];
      $aUser['user'] = $sUser;
      $aUser['password'] = $sPassword;
      $aUser['status'] = 0;
      $aUser['id_profile'] = 2;
      $aUser['email_user'] = [$oEmailUser];
      $oUser = (object)$aUser;

      $aPerson = [];
      $aPerson['name'] = $sName;
      $aPerson['last_name'] = $sLastName;
      $aPerson['users'] = [$oUser];
      $oPerson = (object)$aPerson;

      return personProxy::save($oPerson);
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
