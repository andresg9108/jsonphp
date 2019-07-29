<?php

namespace module\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal, systemException};
use andresg9108\connectiondb\connection;
use model\sendEmail\sendEmailProxy;
use model\setings\setings;

class emailController extends controller {

  private static $instance;
  private $oMail;

  /*
  */
  public function setPHPMailer($oMail){ $this->oMail = $oMail; }

  /*
  */
  public function sendAction($get, $post){
    $iId = (!empty($post->id)) ? $post->id : null;
    $sCod = (!empty($post->cod)) ? $post->cod : '';
    $aSendEmail = [];
    $aSendEmail['id'] = $iId;
    $aSendEmail['cod'] = $sCod;
    $oSendEmail = (object)$aSendEmail;
    $oResponse = sendEmailProxy::validateEmailSending($oSendEmail);

    $aDatos = [];
    $aDatos['email'] = (!empty($oResponse->email)) ? $oResponse->email : '';
    $aDatos['subject'] = (!empty($oResponse->subject)) ? $oResponse->subject : '';
    $aDatos['message'] = (!empty($oResponse->message)) ? $oResponse->message : '';
    $oDatos = (object)$aDatos;
    $this->sendEmail($oDatos);

    $oResponse = sendEmailProxy::registerEmailSent($oSendEmail);

    return Useful::getResponseArray(1, $oResponse,
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'), 
      constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
  }

  /*
  */
  private function sendEmail($oDatos){
    $sEmail = (!empty($oDatos->email)) ? $oDatos->email : '';
    $sSubject = (!empty($oDatos->subject)) ? $oDatos->subject : '';
    $sMessage = (!empty($oDatos->message)) ? $oDatos->message : '';

    $oConnection = Useful::getConnectionDB();
    $oConnection->connect();
    $oMailD = Useful::getMailArrayDB($oConnection);
    $sServerName = (!empty($oMailD->name)) ? $oMailD->name : "";
    $sServerHost = (!empty($oMailD->host)) ? $oMailD->host : "";
    $sSmtpSecure = (!empty($oMailD->smtp_secure)) ? $oMailD->smtp_secure : "";
    $sServerPort = (!empty($oMailD->port)) ? $oMailD->port : "";
    $sServerUsername = (!empty($oMailD->username)) ? $oMailD->username : "";
    $sServerPassword = (!empty($oMailD->password)) ? $oMailD->password : "";

    $this->oMail->isSMTP();//Protocolo
    $this->oMail->CharSet = 'UTF-8';
    $this->oMail->SMTPDebug = 0;//SMTP Debug
    $this->oMail->Debugoutput = "html";//Salida de debug en html
    $this->oMail->Host = $sServerHost;//Servidor
    $this->oMail->Port = $sServerPort;//Puerto
    if(!empty($sSmtpSecure))
      $this->oMail->SMTPSecure = $sSmtpSecure;
    $this->oMail->SMTPAuth = TRUE;//Autenticacion
    $this->oMail->Username = $sServerUsername;//Usuario
    $this->oMail->Password = $sServerPassword;//Password
    $this->oMail->setFrom($sServerUsername, $sServerName);//De
    $this->oMail->addReplyTo($sServerUsername, $sServerName);//Responder a

    $this->oMail->addAddress($sEmail, '');
    $this->oMail->Subject = $sSubject;
    $this->oMail->msgHTML($sMessage);

    if (!$this->oMail->send()) {
      $sMailError = $this->oMail->ErrorInfo;
      throw new systemException($sMailError);
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
