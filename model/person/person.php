<?php

namespace model\person;

use lib\MVC\model;
use lib\Util\Util;
use model\person\queryPerson;
use model\user\user;

class person extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sName;
  public $sLastName;
  public $aUsers;
  public $sMessageErr;

  // Construct
  function __construct($oConnection){
    $this->oConnection = $oConnection;

    $this->iId = null;
    $this->sMessageErr = '';
  }

  /*
  */
  public function save(){
    $this->validateData();

    if(is_null($this->iId)){
      $this->insert();
    }else{
      $this->update();
    }
  }

  /*
  */
  public function validateData(){
    if(empty($this->sName)){
      $this->sMessageErr = 'Debes agregar un nombre para la persona.';
      throw new systemException('', 1);
    }

    if(empty($this->sLastName)){
      $this->sMessageErr = 'Debes agregar un apellido para la persona.';
      throw new systemException('', 1);
    }
  }

  /*
  */
  public function insert(){
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
