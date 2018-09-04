<?php

namespace model\emailUser;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use lib\Useful\{Useful, constantGlobal};
use model\{connection, systemException};
use model\emailUser\{queryEmailUser, constantEmailUser};

class emailUser extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sEmail;
  public $sRegistrationCode;
  public $iStatus;
  public $iMain;
  public $iIdUser;

  // Construct
  function __construct($oConnection){
    $this->oConnection = $oConnection;

    $this->iId = null;
    $this->iIdUser = null;
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

    $oEmailUser = clone $this;

    $oEmailUser->iId = null;
    $oEmailUser->sEmail = $this->sEmail;
    $oEmailUser->loadByEmail();
    if(!is_null($oEmailUser->iId)){
      $aParameters = [$this->sEmail];
      throw new systemException(constantEmailUser::getConstant('VAL_EXISTING_EMAIL', $aParameters));
    }

    unset($oEmailUser);
  }

  /*
  */
  public function validateUpdate(){
    $this->validateData();
  }

  /*
  */
  public function validateData(){
    if(empty($this->sEmail)){
      throw new systemException(constantEmailUser::getConstant('VAL_EMPTY_EMAIL'));
    }

    if(!Useful::validateEmail($this->sEmail)){
      throw new systemException(constantEmailUser::getConstant('VAL_VAL_EMAIL'));
    }
  }

  /*
  */
  public function insert(){
    $this->validateInsert();

    $aParameters = [$this->sEmail, $this->sRegistrationCode, $this->iMain, $this->iStatus, $this->iIdUser];
    $sQuery = queryEmailUser::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = $this->oConnection->getIDInsert();
  }

  /*
  */
  public function update(){
    $this->validateUpdate();

    $aParameters = [$this->iId, $this->sEmail, $this->sRegistrationCode, $this->iStatus, $this->iMain, $this->iIdUser];
    $sQuery = queryEmailUser::getQuery('UPDATE', $aParameters);
    
    $this->oConnection->run($sQuery);
  }

  /*
  */
  public function delete(){
  }

  /*
  */
  public function load(){
    $aParameters = [$this->iId];
    $sQuery = queryEmailUser::getQuery('LOAD', $aParameters);
    $aParameters = ['id', 'email', 'registration_code', 'main', 'status', 'id_user'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oEmailUser = $this->oConnection->getQuery();

    $iId = (!empty($oEmailUser->id)) ? $oEmailUser->id : null;
    $sEmail = (!empty($oEmailUser->email)) ? $oEmailUser->email : '';
    $sRegistrationCode = (!empty($oEmailUser->registration_code)) ? $oEmailUser->registration_code : '';
    $iMain = (!empty($oEmailUser->main)) ? $oEmailUser->main : null;
    $iStatus = (!empty($oEmailUser->status)) ? $oEmailUser->status : null;
    $iIdUser = (!empty($oEmailUser->id_user)) ? $oEmailUser->id_user : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sRegistrationCode = $sRegistrationCode;
    $this->iMain = $iMain;
    $this->iStatus = $iStatus;
    $this->iIdUser = $iIdUser;
  }

  /*
  */
  public function loadByEmail(){
    $aParameters = [$this->sEmail];
    $sQuery = queryEmailUser::getQuery('LOAD_BY_EMAIL', $aParameters);
    $aParameters = ['id', 'email', 'registration_code', 'main', 'status', 'id_user'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oEmailUser = $this->oConnection->getQuery();

    $iId = (!empty($oEmailUser->id)) ? $oEmailUser->id : null;
    $sEmail = (!empty($oEmailUser->email)) ? $oEmailUser->email : '';
    $sRegistrationCode = (!empty($oEmailUser->registration_code)) ? $oEmailUser->registration_code : '';
    $iMain = (!empty($oEmailUser->main)) ? $oEmailUser->main : null;
    $iStatus = (!empty($oEmailUser->status)) ? $oEmailUser->status : null;
    $iIdUser = (!empty($oEmailUser->id_user)) ? $oEmailUser->id_user : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sRegistrationCode = $sRegistrationCode;
    $this->iMain = $iMain;
    $this->iStatus = $iStatus;
    $this->iIdUser = $iIdUser;
  }

  /*
  */
  public function loadMainByIdUser(){
    $aParameters = [$this->iIdUser];
    $sQuery = queryEmailUser::getQuery('LOAD_MAIN_BY_ID_USER', $aParameters);
    $aParameters = ['id', 'email', 'registration_code', 'main', 'status', 'id_user'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oEmailUser = $this->oConnection->getQuery();

    $iId = (!empty($oEmailUser->id)) ? $oEmailUser->id : null;
    $sEmail = (!empty($oEmailUser->email)) ? $oEmailUser->email : '';
    $sRegistrationCode = (!empty($oEmailUser->registration_code)) ? $oEmailUser->registration_code : '';
    $iMain = (!empty($oEmailUser->main)) ? $oEmailUser->main : null;
    $iStatus = (!empty($oEmailUser->status)) ? $oEmailUser->status : null;
    $iIdUser = (!empty($oEmailUser->id_user)) ? $oEmailUser->id_user : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sRegistrationCode = $sRegistrationCode;
    $this->iMain = $iMain;
    $this->iStatus = $iStatus;
    $this->iIdUser = $iIdUser;
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
