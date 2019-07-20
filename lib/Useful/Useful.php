<?php

namespace lib\Useful;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use andresg9108\connectiondb\connection;
use lib\Useful\{constantGlobal, systemException};
use model\sendEmail\sendEmail;
use model\setings\setings;

class Useful {
  public static $aMail = [];

  public static $aConnection = [
    'motor' => 'mysql',
    'server' => 'localhost',
    'charset' => 'utf8',
    'user' => 'root',
    'password' => '',
    'database' => 'my_database',
    'query_prefix' => 'MSQL_',
    'constant_prefix' => '',
    //'constant_prefix' => 'SPAN_',
    'language_id' => 1,
    'encryption_red_cod' => 30,
    'recaptcha' => false,
    'php_errors' => true,
    'system_errors' => true,
    'recaptcha_secret_key' => '6Ld7vmoU',
    'recaptcha_secret_key_hidden' => '6LdoshR',
    's_private_key_only_server' => 'dasf1s5GSG52',
    's_private_key' => 'a5vbFgFFG4Fd2',
    'i_private_key' => 15628
    //'maximum_session_time' => 86400 // (24*60*60 = 86400)
  ];

  /*
  */
  public static function getMailArrayDB($oConnection) {
    return static::getSettingsObjDb(2, $oConnection);
  }

  /*
  */
  public static function getConnectionArrayDB($oConnection) {
    return static::getSettingsObjDb(1, $oConnection);
  }

  /*
  */
  public static function getMailArray() {
    return (object)static::$aMail;
  }

  /*
  */
  public static function getConnectionArray() {
    return (object)static::$aConnection;
  }

  /*
  */
  public static function getConnectionDB(){
    $oConnectionArray = static::getConnectionArray();
    $oConnection = connection::getInstance($oConnectionArray);

    return $oConnection;
  }

  /*
  */
  public static function getFilterPassword($sPassword){
    if(empty($sPassword)){
        throw new systemException(constantGlobal::getConstant('VAL_EMPTY_PASSWORD'));
      }

      if(!static::validatePassword($sPassword)){
        throw new systemException(constantGlobal::getConstant('VAL_VAL_PASSWORD'));
      }

      $sPassword = md5($sPassword);
      return $sPassword;
  }

  /*
  */
  public static function getFilterCharacters($sText) {
    $sText = str_replace("'", '"', $sText);
    $sText = str_replace('<', '<.', $sText);
    $sText = str_replace('>', '.>', $sText);

    return $sText;
  }

  /*
  */
  public static function getResponseArray($status = false, $aResponse = [], $sClient = '',$sDeveloper = '') {
    $oConnection = static::getConnectionArray();
    $bSystemErrors = (!empty($oConnection->system_errors)) ? $oConnection->system_errors :false;
    
    if($bSystemErrors){
      $sText = ['client'=>$sClient, 'developer'=>$sDeveloper];
    }else{
      $sText = ['client'=>$sClient];
    }
    $aResponse = [
      'status'=>$status,
      'response'=>$aResponse,
      'text'=>$sText
    ];

    return (object)$aResponse;
  }

  /*
  */
  public static function getRandomCode(){
    $oConnection = static::getConnectionArray();
    $sPrivateKey = (!empty($oConnection->s_private_key_only_server)) ? $oConnection->s_private_key_only_server : '';
    $sCode = (string)rand(100000, 999999);
    $sCode .= $sPrivateKey;
    $sCode = md5($sCode);

    return $sCode;
  }

  /*
  */
  public static function getJWT($oObject, $oDbConnection){
    $oDbSetings = static::getConnectionArrayDB($oDbConnection);

    $oConnection = static::getConnectionArray();
    $sPrivateKey = (!empty($oConnection->s_private_key_only_server)) ? $oConnection->s_private_key_only_server : '';
    $iMaximumSessionTime = (int)(!empty($oDbSetings->maximum_session_time)) ? $oDbSetings->maximum_session_time : 0;
    $iTime = time(); // Seg.
    $aToken = [
      "iat" => $iTime, // Start
      "exp" => $iTime+$iMaximumSessionTime, // End
      "code" => $oObject
    ];
    $sJwt = JWT::encode($aToken, $sPrivateKey); // Encode

    return $sJwt;
  }

  public static function getDecodeJWT($sJwt){
    $oConnection = static::getConnectionArray();
    $sPrivateKey = (!empty($oConnection->s_private_key_only_server)) ? $oConnection->s_private_key_only_server : '';
    $oDecoded = JWT::decode($sJwt, $sPrivateKey, ['HS256']);

    return $oDecoded->code;
  }

  /*
  */
  public static function getDecodeRegCod($sRegCod){
    $oConnection = static::getConnectionArray();
    $iPrivateKey = (!empty($oConnection->i_private_key)) ? $oConnection->i_private_key : null;
    $sPrivateKey = (!empty($oConnection->s_private_key)) ? $oConnection->s_private_key : '';

    if($oConnection->encryption_red_cod == 30){
      $aRegCod = explode('.', $sRegCod);
      $iRegCod = 0;

      foreach ($aRegCod as $i => $v) {
        $iDato = (int)$v;
        $iDato2 = $iDato+$iPrivateKey;
        $iRegCod += $iDato2;
      }

      $sRegCod = (string)$iRegCod;
      $sRegCod .= $sPrivateKey;
      $sRegCod = md5($sRegCod);
    }

    return $sRegCod;
  }

  /*
  */
  public static function getStatusReCaptcha($sResponse = ""){
    $oConnection = static::getConnectionArray();
    if($oConnection->recaptcha){
      $sSecret = (!empty($oConnection->recaptcha_secret_key)) ? $oConnection->recaptcha_secret_key : '';
      $sURL = "https://www.google.com/recaptcha/api/siteverify";
      $sRemoteip = $_SERVER['REMOTE_ADDR'];

      $sResponse = file_get_contents($sURL."?secret=".$sSecret."&response=".$sResponse."&remoteip=".$sRemoteip);
      $oResponse = json_decode($sResponse);

      if(!$oResponse->success){
          return false;
      }
    }

    return true;
  }

  /*
  */
  public static function getStatusReCaptchaHidden($sResponse = ""){
    $oConnection = static::getConnectionArray();
    if($oConnection->recaptcha){
      $sSecret = (!empty($oConnection->recaptcha_secret_key_hidden)) ? $oConnection->recaptcha_secret_key_hidden : '';
      $sURL = "https://www.google.com/recaptcha/api/siteverify";
      $sRemoteip = $_SERVER['REMOTE_ADDR'];

      $sResponse = file_get_contents($sURL."?secret=".$sSecret."&response=".$sResponse."&remoteip=".$sRemoteip);
      $oResponse = json_decode($sResponse);

      if(!$oResponse->success){
          return false;
      }
    }

    return true;
  }

  /*
  */
  public static function validateNameOrLastName($sName){
    $sExp = "/^[a-zñáéíóúü\s]*$/i";
    $iResponse = preg_match($sExp, $sName);
    $bResponse = ($iResponse == 1) ? true : false;

    return $bResponse;
  }

  /*
  */
  public static function validateEmail($sEmail){
    $sExp = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
    $iResponse = preg_match($sExp, $sEmail);
    $bResponse = ($iResponse == 1) ? true : false;

    return $bResponse;
  }

  /*
  */
  public static function validateUsername($sUsername){
    $sExp = "/^[a-z0-9\._-]{5,}$/i";
    $iResponse = preg_match($sExp, $sUsername);
    $bResponse = ($iResponse == 1) ? true : false;

    return $bResponse;
  }

  /*
  */
  public static function validatePassword($sPassword){
    $sExp = "/^.{5,}$/i";
    $iResponse = preg_match($sExp, $sPassword);
    $bResponse = ($iResponse == 1) ? true : false;

    return $bResponse;
  }

  /*
  */
  public static function getEmailTemplate($sTemplateName, $aParameters = []){
    $sHtml = '';
    $sRuta = __DIRMAIN__ .'email/templates/'.$sTemplateName.'.html';
    if(is_file($sRuta)){
      $sHtml = file_get_contents($sRuta);
    }

    foreach ($aParameters as $i => $v) {
      $sHtml = str_replace("<".($i+1)."?>", $v, $sHtml);
    }

    $sHtml = str_replace("'", '"', $sHtml);
    return $sHtml;
  }

  /*
  */
  public static function saveEmail($sEmail, $iIdEmailSettings, $sSubject, $sMessage, $oConnection){
    $oSendEmail = sendEmail::getInstance($oConnection);
    $sCode = static::getRandomCode();

    $oSendEmail->iId = null;
    $oSendEmail->sEmail = $sEmail;
    $oSendEmail->sCode = $sCode;
    $oSendEmail->iIdEmailSettings = $iIdEmailSettings;
    $oSendEmail->sSubject = $sSubject;
    $oSendEmail->sMessage = $sMessage;
    $oSendEmail->iStatus = 0;
    $oSendEmail->save();

    $aEmail = [];
    $aEmail['id'] = $oSendEmail->iId;
    $aEmail['cod'] = $oSendEmail->sCode;
    $oEmail = (object)$aEmail;
    
    return $oEmail;
  }

  /*
  */
  public static function getSettingsObjDb($iIdSettingsType, $oConnection){
    $oSetings = setings::getInstance($oConnection);
    $oSetings->iIdSettingsType = $iIdSettingsType;
    $aSetings = $oSetings->getSetingsBySetingsType();

    $aDbSetings = [];
    foreach ($aSetings as $i => $v){
      $aDbSetings[$v->name] = $v->value;
    }

    return (object)$aDbSetings;
  }

  /*
  */
  public static function getStringQueryWhereSQLOr($sAttribute, $aData){
    $sData = '';

    foreach ($aData as $i => $v){
      if ($i != 0) {
        $sData .= ' OR ';
      }

      $sParameter = $sAttribute . " = '" . $v . "'";
      $sData .= $sParameter;
    }

    return $sData;
  }

  /*
  */
  public static function getStringQueryWhereSQLAnd($sAttribute, $aData){
    $sData = '';

    foreach ($aData as $i => $v){
      if ($i != 0) {
        $sData .= ' AND ';
      }

      $sParameter = $sAttribute . " = '" . $v . "'";
      $sData .= $sParameter;
    }

    return $sData;
  }

}
