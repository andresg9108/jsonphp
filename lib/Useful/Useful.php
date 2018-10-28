<?php

namespace lib\Useful;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\constantGlobal;
use model\systemException;
use model\sendEmail\sendEmail;

class Useful {
  public static $aMail = [
    "name"=>"Test",
    "host"=>"smtp.example.com",
    "port"=>"25",
    //"port"=>"465",
    "smtp_secure"=>"", //$mail->SMTPSecure = 'tls'; //ssl (obsoleto) o tls
    "username"=>"info@example.com",
    "password"=>"123456"
  ];

  public static $aConnection = [
    'motor' => 'mysql',
    'query_prefix' => 'MSQL_',
    'constant_prefix' => '',
    //'constant_prefix' => 'SPAN_',
    'server' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'my_database',
    'encryption_red_cod' => 30,
    'recaptcha' => false,
    'php_errors' => true,
    'system_errors' => true,
    'recaptcha_secret_key' => '6Ld7vmoU',
    'recaptcha_secret_key_hidden' => '6LdoshR',
    'maximum_session_time' => 86400, // (24*60*60 = 86400)
    's_private_key_only_server' => 'dasf1s5GSG52',
    's_private_key' => 'a5vbFgFFG4Fd2',
    'i_private_key' => 15628
  ];

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
    $oConnection = (object)static::$aConnection;
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
    $oConnection = (object)static::$aConnection;
    $sPrivateKey = (!empty($oConnection->s_private_key_only_server)) ? $oConnection->s_private_key_only_server : '';
    $sCode = (string)rand(100000, 999999);
    $sCode .= $sPrivateKey;
    $sCode = md5($sCode);

    return $sCode;
  }

  /*
  */
  public static function getJWT($oObject){
    $oConnection = (object)static::$aConnection;
    $sPrivateKey = (!empty($oConnection->s_private_key_only_server)) ? $oConnection->s_private_key_only_server : '';
    $iMaximumSessionTime = (!empty($oConnection->maximum_session_time)) ? $oConnection->maximum_session_time : 0;
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
    $oConnection = (object)static::$aConnection;
    $sPrivateKey = (!empty($oConnection->s_private_key_only_server)) ? $oConnection->s_private_key_only_server : '';
    $oDecoded = JWT::decode($sJwt, $sPrivateKey, ['HS256']);

    return $oDecoded->code;
  }

  /*
  */
  public static function getDecodeRegCod($sRegCod){
    $oConnection = (object)static::$aConnection;
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
    $oConnection = (object)static::$aConnection;
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
    $oConnection = (object)static::$aConnection;
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
}
