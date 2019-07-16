<?php

namespace model\setings;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use lib\Useful\{Useful, systemException};
use andresg9108\connectiondb\connection;
use model\setings\{constantSetings, querySetings};

class setings extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sName;
  public $sDescription;
  public $sValue;
  public $iIdSettingsType;

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
  }

  /*
  */
  public function insert(){
    $this->validateInsert();
  }

  /*
  */
  public function update(){
    $this->validateUpdate();
  }

  /*
  */
  public function delete(){
  }

  public function getSetingsBySetingsType(){
    $aParameters = [$this->iIdSettingsType];
    $sQuery = querySetings::getQuery('GET_SETINGS_BY_SETINGS_TYPE', $aParameters);
    $aParameters = ['id', 'registration_date', 'name', 'description', 'value', 'id_settings_type'];
    $this->oConnection->queryArray($sQuery, $aParameters);
    $aSetings = $this->oConnection->getQuery();

    return $aSetings;
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
