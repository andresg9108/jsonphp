<?php

namespace administration\controller;

use lib\MVC\controller;
use lib\Util\{Util, constantGlobal};
use model\appRegistration\appRegistrationProxy;
use model\person\personProxy;
use model\user\userProxy;

class userController extends controller {

  private static $instance;

  /*
  */
  public function logInAction($get, $post){
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
      $sUser = (!empty($post->user)) ? $post->user : '';
      $sPassword = (!empty($post->password)) ? $post->password : '';

      $aUser = [];
      $aUser['user'] = $sUser;
      $aUser['password'] = $sPassword;
      $oUser = (object)$aUser;

      return userProxy::validatelogIn($oUser);
    }else{
      return $oResponse = Util::getResponseArray(false, (object)[]
        ,'', constantGlobal::ERROR_404);
    }
  }

  /*
  */
  public function checkInAction($get, $post){
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
      return $oResponse = Util::getResponseArray(false, (object)[]
        ,'', constantGlobal::ERROR_404);
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

?>
