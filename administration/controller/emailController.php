<?php

namespace administration\controller;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\controller;
use lib\Util\{Util, constantGlobal};
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

        $this->sendEmail($oDatos);
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
  private function sendEmail($oDatos){
    try {
      $sEmail = (!empty($oDatos->email)) ? $oDatos->email : '';
      $sSubject = (!empty($oDatos->subject)) ? $oDatos->subject : '';
      $sMessage = (!empty($oDatos->message)) ? $oDatos->message : '';
      //$sFirma = Util::getFirmaEmail();
      //$sMensaje .= $sFirma;

      $oMailD = Util::getMailArray();
      $sServerName = (!empty($oMailD->name)) ? $oMailD->name : "";
      $sServerHost = (!empty($oMailD->host)) ? $oMailD->host : "";
      $sServerPort = (!empty($oMailD->port)) ? $oMailD->port : "";
      $sServerUsername = (!empty($oMailD->username)) ? $oMailD->username : "";
      $sServerPassword = (!empty($oMailD->password)) ? $oMailD->password : "";

      $this->oMail->isSMTP();//Protocolo
      $this->oMail->SMTPDebug = 2;//SMTP Debug
      $this->oMail->Debugoutput = "html";//Salida de debug en html
      $this->oMail->Host = $sServerHost;//Servidor
      $this->oMail->Port = $sServerPort;//Puerto
      $this->oMail->SMTPAuth = TRUE;//Autenticacion
      $this->oMail->Username = $sServerUsername;//Usuario
      $this->oMail->Password = $sServerPassword;//Password
      $this->oMail->setFrom($sServerUsername, $sServerName);//De
      $this->oMail->addReplyTo($sServerUsername, $sServerName);//Responder a

      $this->oMail->addAddress($sEmail, $sEmail);
      $this->oMail->Subject = $sSubject;
      $this->oMail->msgHTML($sMessage);

      if (!$this->oMail->send()) {
          echo $this->oMail->ErrorInfo;
      } else {
          echo "OK";
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
