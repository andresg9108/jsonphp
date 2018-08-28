<?php

namespace model\person;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use lib\Useful\Useful;
use model\{connection, systemException};
use model\person\{queryPerson, constantPerson};
use model\user\user;

class person extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sName;
  public $sLastName;
  public $aUsers;

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
    if(empty($this->sName)){
      throw new systemException(constantPerson::getConstant('VAL_EMPTY_NAME'));
    }

    if(empty($this->sLastName)){
      throw new systemException(constantPerson::getConstant('VAL_EMPTY_LAST_NAME'));
    }

    if(!Useful::validateNameOrLastName($this->sName)){
      throw new systemException(constantPerson::getConstant('VAL_VAL_NAME'));
    }

    if(!Useful::validateNameOrLastName($this->sLastName)){
      throw new systemException(constantPerson::getConstant('VAL_VAL_LAST_NAME'));
    }
  }

  /*
  */
  public function insert(){
    $this->validateInsert();

    $aParameters = [$this->sName, $this->sLastName];
    $sQuery = queryPerson::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = $this->oConnection->getIDInsert();

    foreach ($this->aUsers as $i => $v) {
      $sEmail = (!empty($v->email)) ? $v->email : '';
      $sUser = (!empty($v->user)) ? $v->user : '';
      $sPassword = (!empty($v->password)) ? $v->password : '';
      $sRegistrationCode = (!empty($v->registration_code)) ? $v->registration_code : '';
      $iStatus = (!empty($v->status)) ? $v->status : 0;
      $iIdProfile = (!empty($v->id_profile)) ? $v->id_profile : null;

      $oUser = user::getInstance($this->oConnection);
      $oUser->iId = null;
      $oUser->sEmail = $sEmail;
      $oUser->sUser = $sUser;
      $oUser->iStatus = $iStatus;
      $oUser->sRegistrationCode = $sRegistrationCode;
      $oUser->sPassword = $sPassword;
      $oUser->iIdPerson = $this->iId;
      $oUser->iIdProfile = $iIdProfile;
      $oUser->save();
    }
  }

  /*
  */
  public function update(){
    $this->validateUpdate();
  }

  /*
  */
  public static function getInstance($oConnection){
    if(static::$instance === null){
        static::$instance = new static($oConnection);
    }
    return static::$instance;
  }

}
