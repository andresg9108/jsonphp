<?php

namespace administration\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Useful\{Useful, constantGlobal};
use model\systemException;
use model\sendEmail\sendEmailProxy;

class emailController extends controller {

  private static $instance;
  private $oMail;

  /*
  */
  public function setPHPMailer($oMail){ $this->oMail = $oMail; }

  /*
  */
  public function sendAction($get, $post){
    try {
      $iId = (!empty($post->id)) ? $post->id : null;
      $sCod = (!empty($post->cod)) ? $post->cod : '';

      $aSendEmail = [];
      $aSendEmail['id'] = $iId;
      $aSendEmail['cod'] = $sCod;
      $oSendEmail = (object)$aSendEmail;

      $oResponse = sendEmailProxy::validateEmailSending($oSendEmail);
      $oResponse = $oResponse->response;
      if($oResponse->valid){
        $aDatos = [];
        $aDatos['email'] = (!empty($oResponse->email)) ? $oResponse->email : '';
        $aDatos['subject'] = (!empty($oResponse->subject)) ? $oResponse->subject : '';
        $aDatos['message'] = (!empty($oResponse->message)) ? $oResponse->message : '';
        $oDatos = (object)$aDatos;

        return $this->sendEmail($oDatos);
      }else{
        return $oResponse = Useful::getResponseArray(2, (object)[]
          ,'', constantGlobal::ERROR_404);
      }
    } catch (systemException $e) {
      return $oResponse = Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
    } catch (Exception $e){
      return $oResponse = Useful::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().') ' . $e->getMessage());
    } catch (ExpiredException $e) {
      return $oResponse = Useful::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
    }
  }

  /*
  */
  private function sendEmail($oDatos){
    try {
      $sEmail = (!empty($oDatos->email)) ? $oDatos->email : '';
      $sSubject = (!empty($oDatos->subject)) ? $oDatos->subject : '';
      $sMessage = (!empty($oDatos->message)) ? $oDatos->message : '';

      $oMailD = Useful::getMailArray();
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

      $this->oMail->addAddress($sEmail, $sEmail);
      $this->oMail->Subject = $sSubject;
      $this->oMail->msgHTML($sMessage);

      if (!$this->oMail->send()) {
        $sMailError = $this->oMail->ErrorInfo;
        return Useful::getResponseArray(2, (object)[], 
          '', $sMailError);
      }

      return Useful::getResponseArray(1, (object)[], 
        '', 
        constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
    } catch (Exception $e){
      return Useful::getResponseArray(2, (object)[], 
          '', $e->getMessage());
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
