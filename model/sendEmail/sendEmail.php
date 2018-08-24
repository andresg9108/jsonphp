<?php

namespace model\sendEmail;

use lib\MVC\model;
use model\sendEmail\querySendEmail;

class sendEmail extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sEmail;
  public $sCode;
  public $sSubject;
  public $sMessage;
  public $iIdEmail;

  // Construct
  function __construct($oConnection){
    $this->oConnection = $oConnection;

    $this->iId = null;
  }
  
  /*
  */
  public function save(){
    if(is_null($this->iId)){
      $this->insert();
    }else{
      $this->update();
    }
  }

  /*
  */
  public function insert(){
    $aParameters = [$this->sEmail, $this->sCode, $this->sSubject, $this->sMessage, $this->iIdEmail];
    $sQuery = querySendEmail::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = $this->oConnection->getIDInsert();
  }

  /*
  */
  public function update(){
  }

  /*
  */
  public function delete(){
    $aParameters = [$this->iId];
    $sQuery = querySendEmail::getQuery('DELETE', $aParameters);

    $this->oConnection->run($sQuery);
  }

  /*
  */
  public function load(){
    $aParameters = [$this->iId];
    $sQuery = querySendEmail::getQuery('LOAD', $aParameters);
    $aParameters = ["id", "registration_date", "email", "code", "subject", "message", "id_email"];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oSendEmail = $this->oConnection->getQuery();

    $iId = (!empty($oSendEmail->id)) ? $oSendEmail->id : null;
    $sEmail = (!empty($oSendEmail->email)) ? $oSendEmail->email : '';
    $sCode = (!empty($oSendEmail->code)) ? $oSendEmail->code : '';
    $sSubject = (!empty($oSendEmail->subject)) ? $oSendEmail->subject : '';
    $sMessage = (!empty($oSendEmail->message)) ? $oSendEmail->message : '';
    $iIdEmail = (!empty($oSendEmail->id_email)) ? $oSendEmail->id_email : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sCode = $sCode;
    $this->sSubject = $sSubject;
    $this->sMessage = $sMessage;
    $this->iIdEmail = $iIdEmail;
  }

  /*
  */
  public static function getInstance($oConnection){
    if(self::$instance === null){
        self::$instance = new self($oConnection);
    }
    return self::$instance;
  }

}
