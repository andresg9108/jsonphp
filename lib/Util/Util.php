<?php

namespace lib\Util;

use Firebase\JWT\JWT;

class Util {
  public static $aMail = [
    "name"=>"Test",
    "host"=>"smtp.example.net",
    "port"=>"25",
    //"port"=>"465",
    "username"=>"info@example.net",
    "password"=>""
  ];

  public static $aConnection = [
    'motor' => 'mysql',
    'query_prefix' => 'MSQL_',
    'server' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'my_database',
    'encryption_red_cod' => true,
    'recaptcha' => false,
    'php_errors' => true,
    'recaptcha_secret_key' => '6Ld7vmoUAAArJlmxnPc',
    'recaptcha_secret_key_hidden' => '6LdoshRlMcnEciKwUI5B',
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
  public static function getFilterCharacters($sText) {
    $sText = str_replace("'", '"', $sText);
    $sText = str_replace('<', '<.', $sText);
    $sText = str_replace('>', '.>', $sText);

    return $sText;
  }

  /*
  */
  public static function getResponseArray($status = false, $aResponse = [], $sClient = '',$sDeveloper = '') {
    $sText = ['client'=>$sClient, 'developer'=>$sDeveloper];
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
  public function getJWT($oObject){
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

  public function getDecodeJWT($sJwt){
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

    if($oConnection->encryption_red_cod){
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
}
