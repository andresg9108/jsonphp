<?php

namespace module\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal, systemException};
use model\appRegistration\appRegistrationProxy;
use model\person\personProxy;
use model\user\userProxy;

class userController extends controller {

  private static $instance;

  /*
  */
  public function sendRecoverPasswordAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
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

    $oResponse = userProxy::sendRecoverPassword($iIdEUser, $sCodeEUser, $sPassword);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
  }


  /*
  */
  public function validateRecoverPasswordAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
    // END APP VALIDATION

    $iIdEUser = (!empty($post->ideuser)) ? $post->ideuser : null;
    $sCodeEUser = (!empty($post->codeeuser)) ? $post->codeeuser : '';

    $oResponse = userProxy::validateRecoverPassword($iIdEUser, $sCodeEUser);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
  }

  /*
  */
  public function recoverPasswordAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
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

    $oResponse = userProxy::recoverPassword($sEmail);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
  }

  /*
  */
  public function validateEmailByCodeAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
    // END APP VALIDATION

    $iIdUser = (!empty($post->id_user)) ? $post->id_user : null;
    $sCodeUser = (!empty($post->code_user)) ? $post->code_user : '';

    $oResponse = userProxy::validateEmailByCode($iIdUser, $sCodeUser);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
  }

  /*
  */
  public function validateSessionAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
    // END APP VALIDATION

    $sCode = (!empty($post->code)) ? $post->code : '';
    $oObject = Useful::getDecodeJWT($sCode);
    $iId = (!empty($oObject->id)) ? $oObject->id : null;
    $iProfile = (!empty($oObject->profile)) ? $oObject->profile : null;
    $aResponse = [];
    $aResponse['profile'] = $iProfile;

    return Useful::getResponseArray(1, (object)$aResponse, '', '');
  }

  /*
  */
  public function validateEmailAndUserAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
    // END APP VALIDATION

    $sEmail = (!empty($post->email)) ? $post->email : '';
    $sUser = (!empty($post->user)) ? $post->user : '';

    $oResponse = userProxy::validateEmailAndUser($sEmail, $sUser);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
  }

  /*
  */
  public function logInAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
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

    $oResponse = userProxy::validatelogIn($oUser);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
  }

  /*
  */
  public function checkInAction($get, $post){
    // BEGIN APP VALIDATION
    $iId = (!empty($post->id)) ? $post->id : null;
    $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
    appRegistrationProxy::validateRegCod($iId, $sRegistrationCode);
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

    $oResponse = personProxy::checkIn($oPerson);

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
