<?php

namespace model\appRegistration;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use lib\Useful\{Useful, systemException};
use andresg9108\connectiondb\connection;
use model\appRegistration\{constantAppRegistration, queryAppRegistration};

class appRegistration extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
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
  public function load(){
    $aParameters = [$this->iId];
    $sQuery = queryAppRegistration::getQuery('LOAD', $aParameters);
    $this->oConnection->queryRow($sQuery);
    $oAppRegistration = $this->oConnection->getQuery();

    $iId = (!empty($oAppRegistration->id)) ? $oAppRegistration->id : null;
    $sRegistrationCode = (!empty($oAppRegistration->registration_code)) ? $oAppRegistration->registration_code : '';

    $this->iId = $iId;
    $this->sRegistrationCode = $sRegistrationCode;
  }

  /*
  */
  public function insert(){
    $this->validateInsert();

    $aParameters = [$this->sRegistrationCode];
    $sQuery = queryAppRegistration::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = (int)$this->oConnection->getIDInsert();
  }

  /*
  */
  public function update(){
    $this->validateUpdate();
  }

  /*
  */
  public function delete(){
    $aParameters = [$this->iId];
    $sQuery = queryAppRegistration::getQuery('DELETE', $aParameters);

    $this->oConnection->run($sQuery);
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
