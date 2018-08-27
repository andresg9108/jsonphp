<?php

namespace model\user;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use lib\Util\Util;
use model\{connection, systemException};
use model\user\{queryUser, constantUser};

class user extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sEmail;
  public $sUser;
  public $sPassword;
  public $iIdPerson;
  public $iIdProfile;
  public $iStatus;
  public $sRegistrationCode;

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
    $this->validateInsert();

    $aParameters = [$this->sEmail, $this->sUser, $this->sPassword, $this->iStatus, $this->sRegistrationCode, $this->iIdPerson, $this->iIdProfile];
    $sQuery = queryUser::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = $this->oConnection->getIDInsert();
  }

  /*
  */
  public function update(){
    $this->validateUpdate();

    $aParameters = [$this->iId, $this->sEmail, $this->sUser, $this->sPassword, $this->iStatus, $this->sRegistrationCode, $this->iIdPerson, $this->iIdProfile];
    $sQuery = queryUser::getQuery('UPDATE', $aParameters);
    
    $this->oConnection->run($sQuery);
  }

  /*
  */
  public function load(){
    $aParameters = [$this->iId];
    $sQuery = queryUser::getQuery('LOAD', $aParameters);
    $aParameters = ['id', 'registration_date', 'email', 'user',
        'password', 'status', 'registration_code', 'id_person', 'id_profile'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oUser = $this->oConnection->getQuery();

    $iId = (!empty($oUser->id)) ? $oUser->id : null;
    $sEmail = (!empty($oUser->email)) ? $oUser->email : '';
    $sUser = (!empty($oUser->user)) ? $oUser->user : '';
    $sPassword = (!empty($oUser->password)) ? $oUser->password : '';
    $iStatus = (!empty($oUser->status)) ? $oUser->status : '0';
    $sRegistrationCode = (!empty($oUser->registration_code)) ? $oUser->registration_code : '';
    $iIdPerson = (!empty($oUser->id_person)) ? $oUser->id_person : null;
    $iIdProfile = (!empty($oUser->id_profile)) ? $oUser->id_profile : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sUser = $sUser;
    $this->sPassword = $sPassword;
    $this->iStatus = $iStatus;
    $this->sRegistrationCode = $sRegistrationCode;
    $this->iIdPerson = $iIdPerson;
    $this->iIdProfile = $iIdProfile;
  }

  /*
  */
  public function loadXUser(){
    $aParameters = [$this->sUser];
    $sQuery = queryUser::getQuery('LOADXUSER', $aParameters);
    $aParameters = ['id', 'registration_date', 'email', 'user',
        'password', 'status', 'registration_code', 'id_person', 'id_profile'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oUser = $this->oConnection->getQuery();

    $iId = (!empty($oUser->id)) ? $oUser->id : null;
    $sEmail = (!empty($oUser->email)) ? $oUser->email : '';
    $sUser = (!empty($oUser->user)) ? $oUser->user : '';
    $sPassword = (!empty($oUser->password)) ? $oUser->password : '';
    $iStatus = (!empty($oUser->status)) ? $oUser->status : '0';
    $sRegistrationCode = (!empty($oUser->registration_code)) ? $oUser->registration_code : '';
    $iIdPerson = (!empty($oUser->id_person)) ? $oUser->id_person : null;
    $iIdProfile = (!empty($oUser->id_profile)) ? $oUser->id_profile : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sUser = $sUser;
    $this->sPassword = $sPassword;
    $this->iStatus = $iStatus;
    $this->sRegistrationCode = $sRegistrationCode;
    $this->iIdPerson = $iIdPerson;
    $this->iIdProfile = $iIdProfile;
  }

  /*
  */
  public function loadXEmail(){
    $aParameters = [$this->sEmail];
    $sQuery = queryUser::getQuery('LOADXEMAIL', $aParameters);
    $aParameters = ['id', 'registration_date', 'email', 'user',
        'password', 'status', 'registration_code', 'id_person', 'id_profile'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oUser = $this->oConnection->getQuery();

    $iId = (!empty($oUser->id)) ? $oUser->id : null;
    $sEmail = (!empty($oUser->email)) ? $oUser->email : '';
    $sUser = (!empty($oUser->user)) ? $oUser->user : '';
    $sPassword = (!empty($oUser->password)) ? $oUser->password : '';
    $iStatus = (!empty($oUser->status)) ? $oUser->status : '0';
    $sRegistrationCode = (!empty($oUser->registration_code)) ? $oUser->registration_code : '';
    $iIdPerson = (!empty($oUser->id_person)) ? $oUser->id_person : null;
    $iIdProfile = (!empty($oUser->id_profile)) ? $oUser->id_profile : null;

    $this->iId = $iId;
    $this->sEmail = $sEmail;
    $this->sUser = $sUser;
    $this->sPassword = $sPassword;
    $this->iStatus = $iStatus;
    $this->sRegistrationCode = $sRegistrationCode;
    $this->iIdPerson = $iIdPerson;
    $this->iIdProfile = $iIdProfile;
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
    $this->sUser = (!empty($this->sUser)) ? str_replace(' ', '', $this->sUser) : '';
    $this->sEmail = (!empty($this->sEmail)) ? str_replace(' ', '', $this->sEmail) : '';
    $sUser = $this->sUser;
    $sPassword = $this->sPassword;
    $this->sUser = md5($this->sUser);
    $this->sPassword = md5($this->sPassword);

    if(empty($this->sEmail)){
      throw new systemException(constantUser::getConstant('VAL_EMPTY_EMAIL'));
    }

    if(empty($sUser)){
      throw new systemException(constantUser::getConstant('VAL_EMPTY_USUARIO'));
    }

    if(empty($sPassword)){
      throw new systemException(constantUser::getConstant('VAL_EMPTY_PASSWORD'));
    }

    if(!Util::validateEmail($this->sEmail)){
      throw new systemException(constantUser::getConstant('VAL_VAL_EMAIL'));
    }

    if(!Util::validateUsername($sUser)){
      throw new systemException(constantUser::getConstant('VAL_VAL_USERNAME'));
    }

    if(!Util::validatePassword($sPassword)){
      throw new systemException(constantUser::getConstant('VAL_VAL_PASSWORD'));
    }

    $oUser = clone $this;

    $oUser->iId = null;
    $oUser->sEmail = $this->sEmail;
    $oUser->loadXEmail();
    if(!is_null($oUser->iId)){
      $aParameters = [$this->sEmail];
      throw new systemException(constantUser::getConstant('VAL_EXISTING_EMAIL', $aParameters));
    }

    $oUser->iId = null;
    $oUser->sUser = $this->sUser;
    $oUser->loadXUser();
    if(!is_null($oUser->iId)){
      $aParameters = [$sUser];
      throw new systemException(constantUser::getConstant('VAL_EXISTING_USERNAME', $aParameters));
    }

    unset($oUser);
  }

  public function getUsersByIdPerson(){
    $aParameters = [$this->iIdPerson];
    $sQuery = queryUser::getQuery('SELECT_BY_ID_PERSON', $aParameters);
    $aParameters = ['id', 'registration_date', 'email', 'user', 'password', 'status', 'registration_code', 'id_person', 'id_profile'];
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
