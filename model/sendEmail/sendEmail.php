<?php

namespace model\sendEmail;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use model\{connection, systemException};
use model\sendEmail\{querySendEmail, constantSendEmail};

class sendEmail extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sEmail;
  public $sCode;
  public $sSubject;
  public $sMessage;
  public $iStatus;
  public $iIdEmailSettings;

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
  public function validateInsert(){
    $this->validateData();
  }

  /*
  */
  public function validateUpdate(){
    $this->validateData();
  }

  /*
  */
  public function validateData(){
  }

  /*
  */
  public function insert(){
    $this->validateInsert();

    $aParameters = [$this->sEmail, $this->sCode, $this->sSubject, $this->sMessage, $this->iStatus, $this->iIdEmailSettings];
    $sQuery = querySendEmail::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = $this->oConnection->getIDInsert();
  }

  /*
  */
  public function update(){
    $this->validateUpdate();

    $aParameters = [$this->iId, $this->sEmail, $this->sCode, $this->sSubject, $this->sMessage, $this->iStatus, $this->iIdEmailSettings];
    $sQuery = querySendEmail::getQuery('UPDATE', $aParameters);

    $this->oConnection->run($sQuery);
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
    $aParameters = ["id", "registration_date", "email", "code", "subject", "message", "status", "id_email_settings"];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oSendEmail = $this->oConnection->getQuery();

    $iId = (!empty($oSendEmail->id)) ? $oSendEmail->id : null;
    $sEmail = (!empty($oSendEmail->email)) ? $oSendEmail->email : '';
    $sCode = (!empty($oSendEmail->code)) ? $oSendEmail->code : '';
    $sSubject = (!empty($oSendEmail->subject)) ? $oSendEmail->subject : '';
    $sMessage = (!empty($oSendEmail->message)) ? $oSendEmail->message : '';
    $iStatus = (!empty($oSendEmail->status)) ? $oSendEmail->status : 0;
    $iIdEmailSettings = (!empty($oSendEmail->id_email_settings)) ? $oSendEmail->id_email_settings : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sCode = $sCode;
    $this->sSubject = $sSubject;
    $this->sMessage = $sMessage;
    $this->iStatus = $iStatus;
    $this->iIdEmailSettings = $iIdEmailSettings;
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
