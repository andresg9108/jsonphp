<?php

namespace administration\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Util\{Util, constantGlobal};
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
      $oResponse = $oResponse->response;
      $bValidate = (!empty($oResponse->validate)) ? $oResponse->validate : false;

      if($bValidate){
        $sEmail = (!empty($post->email)) ? $post->email : '';

        return userProxy::recoverPassword($sEmail);
      }else{
        return $oResponse = Util::getResponseArray(2, (object)[]
          ,'', constantGlobal::ERROR_404);
      }
    } catch (systemException $e) {
      return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), constantGlobal::CONTROLLED_EXCEPTION . '(Code: '.$e->getCode().')');
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().')' . $e->getMessage());
    } catch (ExpiredException $e) {
      return $oResponse = Util::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
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
      $oResponse = $oResponse->response;
      $bValidate = (!empty($oResponse->validate)) ? $oResponse->validate : false;

      if($bValidate){
        $iIdUser = (!empty($post->id_user)) ? $post->id_user : null;
        $sCodeUser = (!empty($post->code_user)) ? $post->code_user : '';

        return [$iIdUser, $sCodeUser];
      }else{
        return $oResponse = Util::getResponseArray(2, (object)[]
          ,'', constantGlobal::ERROR_404);
      }
    } catch (systemException $e) {
      return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), constantGlobal::CONTROLLED_EXCEPTION . '(Code: '.$e->getCode().')');
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().')' . $e->getMessage());
    } catch (ExpiredException $e) {
      return $oResponse = Util::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
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
      $oResponse = $oResponse->response;
      $bValidate = (!empty($oResponse->validate)) ? $oResponse->validate : false;

      if($bValidate){
        $sCode = (!empty($post->code)) ? $post->code : '';
        $oObject = Util::getDecodeJWT($sCode);
        $iId = (!empty($oObject->id)) ? $oObject->id : null;
        $iProfile = (!empty($oObject->profile)) ? $oObject->profile : null;
        
        return $oResponse = Util::getResponseArray(1, (object)[], 
          'Datos de sesion correctos.', 
          'Datos de sesion correctos.');
      }else{
        return $oResponse = Util::getResponseArray(2, (object)[]
          ,'', constantGlobal::ERROR_404);
      }
    } catch (systemException $e) {
      return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), constantGlobal::CONTROLLED_EXCEPTION . '(Code: '.$e->getCode().')');
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().')' . $e->getMessage());
    } catch (ExpiredException $e) {
      return $oResponse = Util::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
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
      $oResponse = $oResponse->response;
      $bValidate = (!empty($oResponse->validate)) ? $oResponse->validate : false;

      if($bValidate){
        $sEmail = (!empty($post->email)) ? $post->email : '';
        $sUser = (!empty($post->user)) ? $post->user : '';

        return userProxy::validateEmailAndUser($sEmail, $sUser);
      }else{
        return $oResponse = Util::getResponseArray(2, (object)[]
          ,'', constantGlobal::ERROR_404);
      }
    } catch (systemException $e) {
      return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), constantGlobal::CONTROLLED_EXCEPTION . '(Code: '.$e->getCode().')');
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().')' . $e->getMessage());
    } catch (ExpiredException $e) {
      return $oResponse = Util::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
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
      $oResponse = $oResponse->response;
      $bValidate = (!empty($oResponse->validate)) ? $oResponse->validate : false;
      $bReCaptcha = Util::getStatusReCaptchaHidden($sResponse);

      if($bValidate && $bReCaptcha){
        $sUser = (!empty($post->user)) ? $post->user : '';
        $sPassword = (!empty($post->password)) ? $post->password : '';

        $aUser = [];
        $aUser['user'] = $sUser;
        $aUser['password'] = $sPassword;
        $oUser = (object)$aUser;

        return userProxy::validatelogIn($oUser);
      }else{
        return $oResponse = Util::getResponseArray(2, (object)[]
          ,'', constantGlobal::ERROR_404);
      }
    } catch (systemException $e) {
      return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), constantGlobal::CONTROLLED_EXCEPTION . '(Code: '.$e->getCode().')');
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().')' . $e->getMessage());
    } catch (ExpiredException $e) {
      return $oResponse = Util::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
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
      $oResponse = $oResponse->response;
      $bValidate = (!empty($oResponse->validate)) ? $oResponse->validate : false;
      $bReCaptcha = Util::getStatusReCaptcha($sResponse);

      if($bValidate && $bReCaptcha){
        $sName = (!empty($post->name)) ? $post->name : '';
        $sLastName = (!empty($post->last_name)) ? $post->last_name : '';
        $sEmail = (!empty($post->email)) ? $post->email : '';
        $sUser = (!empty($post->user)) ? $post->user : '';
        $sPassword = (!empty($post->password)) ? $post->password : '';

        $sName = Util::getFilterCharacters($sName);
        $sLastName = Util::getFilterCharacters($sLastName);
        $sEmail = Util::getFilterCharacters($sEmail);
        $sUser = Util::getFilterCharacters($sUser);
        $sPassword = md5($sPassword);

        $sRegistrationCode = Util::getRandomCode();
        $aUser = [];
        $aUser['email'] = $sEmail;
        $aUser['user'] = $sUser;
        $aUser['password'] = $sPassword;
        $aUser['registration_code'] = $sRegistrationCode;
        $aUser['status'] = 0;
        $aUser['id_profile'] = 2;
        $oUser = (object)$aUser;

        $aPerson = [];
        $aPerson['name'] = $sName;
        $aPerson['last_name'] = $sLastName;
        $aPerson['users'] = [$oUser];
        $oPerson = (object)$aPerson;

        return personProxy::save($oPerson);
      }else{
        return $oResponse = Util::getResponseArray(2, (object)[]
          ,'', constantGlobal::ERROR_404);
      }
    } catch (systemException $e) {
      return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), constantGlobal::CONTROLLED_EXCEPTION . '(Code: '.$e->getCode().')');
    } catch (Exception $e){
      return $oResponse = Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().')' . $e->getMessage());
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
