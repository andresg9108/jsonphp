<?php

namespace model\example;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\MVC\model;
use lib\Useful\{Useful, systemException};
use model\connection;
use model\example\{constantExample, queryExample};

class example extends model {

  // Attributes
  private static $instance;
  private $oConnection;
  public $iId;

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

  /*
  */
  public static function getInstance($oConnection){
    if(static::$instance === null){
        static::$instance = new static($oConnection);
    }
    return static::$instance;
  }

}
