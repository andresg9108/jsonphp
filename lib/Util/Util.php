<?php

namespace lib\Util;

use Firebase\JWT\JWT;

class Util {
  public static $aMail = [
    "name"=>"Prueba",
    "host"=>"smtpout.secureserver.net",
    "port"=>"80",
    //"port"=>"465",
    "username"=>"info@vendapues.net",
    "password"=>"InFod6-9D5e89"
  ];

  public static $aConnection = [
    'motor' => 'mysql',
    'query_prefix' => 'MSQL_',
    'server' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'my_database',
    'encryption_red_cod' => true,
    'maximum_session_time' => 86400, // (24*60*60)
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
}

?>
