<?php

namespace lib\Useful;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use andresg9108\connectiondb\connection;
use lib\Useful\{constantGlobal, systemException};
use model\sendEmail\sendEmail;
use model\setings\setings;

class Useful {
  public static $aMail = [
    'name' => 'Email Server',
    'host' => 'smtp.gmail.com',
    'smtp_secure' => 'ssl',
    'port' => '465',
    'username' => 'example@gmail.com',
    'password' => 'asFfv123'
  ];

  public static $aConnection = [
    'motor' => 'sqlitepdo',
    'server' => 'localhost',
    'charset' => 'utf8',
    'user' => 'root',
    'password' => '',
    'database' => 'my_database',
    'sqlitepath' => 'D:/sql/db.sqlite',
    'query_prefix' => 'MSQL_',
    'constant_prefix' => '',
    //'constant_prefix' => 'SPAN_',
    'language_id' => 1,
    'encryption_red_cod' => 30,
    'recaptcha' => false,
    'php_errors' => true,
    'php_timezone' => 'America/Lima', // URL: https://www.php.net/manual/es/timezones.php
    'system_errors' => true,
    'recaptcha_secret_key' => '6Ld7vmoU',
    'recaptcha_secret_key_hidden' => '6LdoshR',
    's_private_key_only_server' => 'dasf1s5GSG52',
    's_private_key' => 'a5vbFgFFG4Fd2',
    'i_private_key' => 15628,
    'maximum_session_time' => 86400 // (24*60*60 = 86400)
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
  public static function getConnectionDB(){
    $oConnectionArray = static::getConnectionArray();
    $oConnection = connection::getInstance($oConnectionArray);

    return $oConnection;
  }

  /*
  */
  public static function getBooleanPhpErrors(){
    $oConnection = static::getConnectionArray();
    $bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;

    return $bPhpErrors;
  }

  /*
  */
  public static function getStringPhpTimezone(){
    $oConnection = static::getConnectionArray();
    $sPhpTimezone = (!empty($oConnection->php_timezone)) ? $oConnection->php_timezone : '';

    return $sPhpTimezone;
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
    $oConnection = static::getConnectionArray();
    $sPrivateKey = (!empty($oConnection->s_private_key_only_server)) ? $oConnection->s_private_key_only_server : '';
    $iMaximumSessionTime = (int)(!empty($oConnection->maximum_session_time)) ? $oConnection->maximum_session_time : 0;
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

}
