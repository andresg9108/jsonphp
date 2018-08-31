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
  public function recoverPasswordAction($get, $post){
    try {
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';

      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);

      if($oResponse->status == 1){
        $sEmail = (!empty($post->email)) ? $post->email : '';

        return userProxy::recoverPassword($sEmail);
      }

      return $oResponse;
    } catch (systemException $e) {
      return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), '(Code: '.$e->getCode().') ' . $e->getMessage());
    } catch (ExpiredException $e) {
      return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
    }
  }

  /*
  */
  public function validateEmailByCodeAction($get, $post){
    try {
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';

      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);

      if($oResponse->status == 1){
        $iIdUser = (!empty($post->id_user)) ? $post->id_user : null;
        $sCodeUser = (!empty($post->code_user)) ? $post->code_user : '';

        return userProxy::validateEmailByCode($iIdUser, $sCodeUser);
      }

      return $oResponse;
    } catch (systemException $e) {
      return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), '(Code: '.$e->getCode().') ' . $e->getMessage());
    } catch (ExpiredException $e) {
      return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
    }
  }

  /*
  */
  public function validateSessionAction($get, $post){
    try {
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';

      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);

      if($oResponse->status == 1){
        $sCode = (!empty($post->code)) ? $post->code : '';
        $oObject = Useful::getDecodeJWT($sCode);
        $iId = (!empty($oObject->id)) ? $oObject->id : null;
        $iProfile = (!empty($oObject->profile)) ? $oObject->profile : null;

        $aResponse = [];
        $aResponse['profile'] = $iProfile;

        return Useful::getResponseArray(1, (object)$aResponse, '', '');
      }

      return $oResponse;
    } catch (systemException $e) {
      return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), '(Code: '.$e->getCode().') ' . $e->getMessage());
    } catch (ExpiredException $e) {
      return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
    }
  }

  /*
  */
  public function validateEmailAndUserAction($get, $post){
    try {
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';

      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);

      if($oResponse->status == 1){
        $sEmail = (!empty($post->email)) ? $post->email : '';
        $sUser = (!empty($post->user)) ? $post->user : '';

        return userProxy::validateEmailAndUser($sEmail, $sUser);
      }

      return $oResponse;
    } catch (systemException $e) {
      return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), '(Code: '.$e->getCode().') ' . $e->getMessage());
    } catch (ExpiredException $e) {
      return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
    }
  }

  /*
  */
  public function logInAction($get, $post){
    try {
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $sResponse = (!empty($post->response)) ? $post->response : '';

      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      $bReCaptcha = Useful::getStatusReCaptchaHidden($sResponse);

      if($oResponse->status == 1 && $bReCaptcha){
        $sUser = (!empty($post->user)) ? $post->user : '';
        $sPassword = (!empty($post->password)) ? $post->password : '';

        $aUser = [];
        $aUser['user'] = $sUser;
        $aUser['password'] = $sPassword;
        $oUser = (object)$aUser;

        return userProxy::validatelogIn($oUser);
      }

      return $oResponse;
    } catch (systemException $e) {
      return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), '(Code: '.$e->getCode().') ' . $e->getMessage());
    } catch (ExpiredException $e) {
      return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
    }
  }

  /*
  */
  public function checkInAction($get, $post){
    try {
      $iId = (!empty($post->id)) ? $post->id : null;
      $sRegistrationCode = (!empty($post->registration_code)) ? $post->registration_code : '';
      $sResponse = (!empty($post->response)) ? $post->response : '';

      $aAppRegistration = [];
      $aAppRegistration['id'] = $iId;
      $aAppRegistration['registration_code'] = $sRegistrationCode;
      $oAppRegistration = (object)$aAppRegistration;
      $oResponse = appRegistrationProxy::validateRegCod($oAppRegistration);
      $bReCaptcha = Useful::getStatusReCaptcha($sResponse);

      if($oResponse->status == 1 && $bReCaptcha){
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
        $sPassword = (!empty($sPassword)) ? md5($sPassword) : '';

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
      }

      return $oResponse;
    } catch (systemException $e) {
      return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), '(Code: '.$e->getCode().') ' . $e->getMessage());
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
