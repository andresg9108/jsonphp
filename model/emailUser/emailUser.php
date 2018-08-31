<?php

namespace model\emailUser;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use model\{connection, systemException};
use model\sendEmail\{queryEmailUser, constantEmailUser};

class emailUser extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;
  public $sEmail;
  public $sRegistrationCode;
  public $iStatus;
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

    $aParameters = [];
    $sQuery = queryEmailUser::getQuery('INSERT', $aParameters);

    $this->oConnection->run($sQuery);
    $this->iId = $this->oConnection->getIDInsert();
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

  /*
  */
  public function load(){
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
