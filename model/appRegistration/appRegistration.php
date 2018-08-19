<?php

namespace model\appRegistration;

use lib\MVC\model;
use lib\Util\Util;
use model\appRegistration\queryAppRegistration;

class appRegistration extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sRegistrationCode;
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
    if(is_null($this->iId)){
      $this->insert();
    }else{
      $this->update();
    }
  }

  /*
  */
  public function load(){
    $aParameters = [$this->iId];
    $sQuery = queryAppRegistration::getQuery('LOAD', $aParameters);
    $aParameters = ['id', 'registration_date', 'registration_code'];
    $this->oConnection->queryRow($sQuery, $aParameters);
    $oAppRegistration = $this->oConnection->getQuery();

    $iId = (!empty($oAppRegistration->id)) ? $oAppRegistration->id : null;
    $sRegistrationCode = (!empty($oAppRegistration->registration_code)) ? $oAppRegistration->registration_code : '';

    $this->iId = $iId;
    $this->sRegistrationCode = $sRegistrationCode;
  }

  /*
  */
  public function insert(){
    $aParameters = [$this->sRegistrationCode];
    $sQuery = queryAppRegistration::getQuery('INSERT', $aParameters);

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

?>
