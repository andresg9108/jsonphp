<?php

namespace model\user;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use lib\Useful\{Useful, systemException};
use model\connection;
use model\user\{queryUser, constantUser};
use model\emailUser\emailUser;

class user extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sUser;
  public $sPassword;
  public $iIdPerson;
  public $iIdProfile;
  public $iStatus;
  public $aEmailUser;

  // Construct
  function __construct($oConnection){
    $this->oConnection = $oConnection;

    $this->iId = null;
    $this->iIdProfile = null;
    $this->iIdPerson = null;
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
    $this->validateInsert();

    $aParameters = [$this->sUser, $this->sPassword, $this->iStatus, $this->iIdPerson, $this->iIdProfile];
    $sQuery = queryUser::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = $this->oConnection->getIDInsert();

    $oEmailUser = emailUser::getInstance($this->oConnection);
    foreach ($this->aEmailUser as $i => $v) {
      $sEmail = (!empty($v->email)) ? $v->email : '';
      $sRegistrationCode = (!empty($v->registration_code)) ? $v->registration_code : '';
      $iMain = (!empty($v->main)) ? $v->main : 0;
      $iStatus = (!empty($v->status)) ? $v->status : 0;
      $iIdUser = $this->iId;

      $oEmailUser->iId = null;
      $oEmailUser->sEmail = $sEmail;
      $oEmailUser->sRegistrationCode = $sRegistrationCode;
      $oEmailUser->iMain = $iMain;
      $oEmailUser->iStatus = $iStatus;
      $oEmailUser->iIdUser = $iIdUser;
      $oEmailUser->save();
    }
  }

  /*
  */
  public function update(){
    $this->validateUpdate();

    $aParameters = [$this->iId, $this->sUser, $this->sPassword, $this->iStatus, $this->iIdPerson, $this->iIdProfile];
    $sQuery = queryUser::getQuery('UPDATE', $aParameters);
    
    $this->oConnection->run($sQuery);
  }
  
  /*
  */
  public function load(){
    $aParameters = [$this->iId];
    $sQuery = queryUser::getQuery('LOAD', $aParameters);
    $aParameters = ['id', 'registration_date', 'user', 'password', 'status', 'id_person', 'id_profile'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oUser = $this->oConnection->getQuery();

    $iId = (!empty($oUser->id)) ? $oUser->id : null;
    $sUser = (!empty($oUser->user)) ? $oUser->user : '';
    $sPassword = (!empty($oUser->password)) ? $oUser->password : '';
    $iStatus = (!empty($oUser->status)) ? $oUser->status : 0;
    $iIdPerson = (!empty($oUser->id_person)) ? $oUser->id_person : null;
    $iIdProfile = (!empty($oUser->id_profile)) ? $oUser->id_profile : null;

    $this->iId = $iId;
    $this->sUser = $sUser;
    $this->sPassword = $sPassword;
    $this->iStatus = $iStatus;
    $this->iIdPerson = $iIdPerson;
    $this->iIdProfile = $iIdProfile;
  }

  /*
  */
  public function loadByUser(){
    $aParameters = [$this->sUser];
    $sQuery = queryUser::getQuery('LOAD_BY_USER', $aParameters);
    $aParameters = ['id', 'registration_date', 'user', 'password', 'status', 'id_person', 'id_profile'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oUser = $this->oConnection->getQuery();

    $iId = (!empty($oUser->id)) ? $oUser->id : null;
    $sUser = (!empty($oUser->user)) ? $oUser->user : '';
    $sPassword = (!empty($oUser->password)) ? $oUser->password : '';
    $iStatus = (!empty($oUser->status)) ? $oUser->status : 0;
    $iIdPerson = (!empty($oUser->id_person)) ? $oUser->id_person : null;
    $iIdProfile = (!empty($oUser->id_profile)) ? $oUser->id_profile : null;

    $this->iId = $iId;
    $this->sUser = $sUser;
    $this->sPassword = $sPassword;
    $this->iStatus = $iStatus;
    $this->iIdPerson = $iIdPerson;
    $this->iIdProfile = $iIdProfile;
  }

  /*
  */
  public function loadByEmailUser(){
    $sOrEmailUser = Useful::getStringQueryWhereSQLOr('eu.email', $this->aEmailUser);
    $aParameters = [$sOrEmailUser];
    $sQuery = queryUser::getQuery('LOAD_BY_EMAIL_USER', $aParameters);
    $aParameters = ['id', 'registration_date', 'user', 'password', 'status', 'id_person', 'id_profile'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oUser = $this->oConnection->getQuery();

    $iId = (!empty($oUser->id)) ? $oUser->id : null;
    $sUser = (!empty($oUser->user)) ? $oUser->user : '';
    $sPassword = (!empty($oUser->password)) ? $oUser->password : '';
    $iStatus = (!empty($oUser->status)) ? $oUser->status : 0;
    $iIdPerson = (!empty($oUser->id_person)) ? $oUser->id_person : null;
    $iIdProfile = (!empty($oUser->id_profile)) ? $oUser->id_profile : null;

    $this->iId = $iId;
    $this->sUser = $sUser;
    $this->sPassword = $sPassword;
    $this->iStatus = $iStatus;
    $this->iIdPerson = $iIdPerson;
    $this->iIdProfile = $iIdProfile;
  }

  /*
  */
  public function validateInsert(){
    $this->validateData();

    $oUser = clone $this;

    $oUser->iId = null;
    $oUser->sUser = $this->sUser;
    $oUser->loadByUser();
    if(!is_null($oUser->iId)){
      $aParameters = [$this->sUser];
      throw new systemException(constantUser::getConstant('VAL_EXISTING_USERNAME', $aParameters));
    }

    unset($oUser);
  }

  /*
  */
  public function validateUpdate(){
    $this->validateData();
  }

  /*
  */
  public function validateData(){
    if(empty($this->sUser)){
      throw new systemException(constantUser::getConstant('VAL_EMPTY_USUARIO'));
    }

    if(!Useful::validateUsername($this->sUser)){
      throw new systemException(constantUser::getConstant('VAL_VAL_USERNAME'));
    }
  }

  public function getUsersByIdPerson(){
    $aParameters = [$this->iIdPerson];
    $sQuery = queryUser::getQuery('SELECT_BY_ID_PERSON', $aParameters);
    $aParameters = ['id', 'registration_date', 'user', 'password', 'status', 'id_person', 'id_profile'];
    $this->oConnection->queryArray($sQuery, $aParameters);
    $aUser = $this->oConnection->getQuery();

    return $aUser;
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
