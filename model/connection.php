<?php

namespace model;

use \Exception;
use \mysqli;
use lib\Useful\{Useful, constantGlobal};

class connection{

	// Attributes
	private static $instance;
	private $oConnection;
	private $sMotor;
	private $sServer;
	private $sUser;
	private $sPassword;
	private $sDatabase;
	private $query;

	// Properties
	public function getQuery(){ return $this->query; }

	// Construct
	function __construct()
	{
		$oConnection = Useful::getConnectionArray();

		$this->sMotor = (isset($oConnection->motor)) ? $oConnection->motor : '';
		$this->sServer = (isset($oConnection->server)) ? $oConnection->server : '';
		$this->sUser = (isset($oConnection->user)) ? $oConnection->user : '';
		$this->sPassword = (isset($oConnection->password)) ? $oConnection->password : '';
		$this->sDatabase = (isset($oConnection->database)) ? $oConnection->database : '';
		$this->query = [];
	}

	  /*
	  */
	  public static function getInstance(){
	    if(static::$instance === null){
	        static::$instance = new static();
	    }
	    return static::$instance;
	  }
	
	  /*
	  */
	  public function connect(){
	    if($this->sMotor == "mysql")
	    	$this->connectMySQL();
	  }

	  /*
	  */
	  public function run($sQuery){
	    if($this->sMotor == "mysql")
	    	$this->runMySQL($sQuery);
	  }

	  /*
	  */
	  public function queryArray($sQuery, $aParameters){
	  	$this->query = [];
	  	
	    if($this->sMotor == "mysql")
	    	$this->queryArrayMySQL($sQuery, $aParameters);
	  }

	  /*
	  */
	  public function queryRow($sQuery, $aParameters){
	  	$this->query = [];
	  	
	    if($this->sMotor == "mysql")
	    	$this->queryRowMySQL($sQuery, $aParameters);
	  }

	  /*
	  */
	  public function commit(){
	      if($this->sMotor == "mysql")
	          $this->commitMySQL();
	  }

	  /*
	  */
	  public function rollback(){
	      if($this->sMotor == "mysql")
	         $this->rollbackMySQL();
	  }

	  /*
	  */
	  public function close(){
	      if($this->sMotor == "mysql")
	          $this->closeMySQL();
	  }
	  
	  /*
	  */
	  public function getIDInsert(){
	  	if($this->sMotor == "mysql")
	  		return $this->getIDInsertMySQL();

	  	return null;
	  }

	/*MySQL*/

	/*
	*/
	private function connectMySQL(){
		$this->oConnection = @new mysqli($this->sServer, $this->sUser, $this->sPassword, $this->sDatabase);
	    if($this->oConnection->connect_error){
	    	$sMessageErr = constantGlobal::getConstant('FAIL_CONNECTION_FAILURE_DB');
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
	    }

	    $this->oConnection->set_charset('utf8');
	    $this->oConnection->autocommit(FALSE);
	}

	/*
	*/
	private function runMySQL($sQuery){
		if($this->oConnection->connect_error){
			$sMessageErr = constantGlobal::getConstant('FAIL_CONNECTION_FAILURE_DB');
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
		}
	    if(!@$this->oConnection->query($sQuery)){
	    	$sMessageErr = constantGlobal::getConstant('ERROR_IN_THE_QUERY');
	    	throw new Exception($sMessageErr.' '.$sQuery);
	    }
	}

	/*
	*/
	private function queryRowMySQL($sQuery, $aParameters){
		if($this->oConnection->connect_error){
			$sMessageErr = constantGlobal::getConstant('FAIL_CONNECTION_FAILURE_DB');
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
		}
	    $oQuery = @$this->oConnection->query($sQuery);
	    if(!$oQuery){
	    	$sMessageErr = constantGlobal::getConstant('ERROR_IN_THE_QUERY');
	    	throw new Exception($sMessageErr.' '.$sQuery);
	    }

	    $aRow = $oQuery->fetch_row();
      	$oResponse = [];
      	if(is_array($aRow)){
      		foreach ($aRow as $i => $v) {
      			$sPosition = (!empty($aParameters[$i])) ? $aParameters[$i] : '';
      			if(!empty($sPosition)){
      				$oResponse[$sPosition] = $v;
      			}
	      	}
      	}

	    $this->query = (object)$oResponse;
	}

	/*
	*/
	private function queryArrayMySQL($sQuery, $aParameters){
		if($this->oConnection->connect_error){
			$sMessageErr = constantGlobal::getConstant('FAIL_CONNECTION_FAILURE_DB');
	    	throw new Exception($sMessageErr.' '.$this->oConnection->connect_error);
		}
	    $oQuery = @$this->oConnection->query($sQuery);
	    if(!$oQuery){
	    	$sMessageErr = constantGlobal::getConstant('ERROR_IN_THE_QUERY');
	    	throw new Exception($sMessageErr.' '.$sQuery);
	    }

	    $aResponse = [];
	    for($i=0;$i<$oQuery->num_rows;$i++){
	      $aRow = $oQuery->fetch_row();
	      $aRow2 = [];
	      if(is_array($aRow)){
	      	foreach ($aRow as $i1 => $v2) {
	      		$sPosition = (!empty($aParameters[$i1])) ? $aParameters[$i1] : '';
	      		if(!empty($sPosition)){
	      			$aRow2[$sPosition] = $v2;
	      		}
	      	}
	      }
	      $aResponse[] = (object)$aRow2;
	    }

	    $this->query = $aResponse;
	}

	/*
	*/
	private function commitMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->commit();
	}

	/*
	*/
	private function rollbackMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->rollback();
	}

	/*
	*/
	private function closeMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->close();
	}

  	/*
	*/
	private function getIDInsertMySQL(){
		if(!$this->oConnection->connect_error)
			return @$this->oConnection->insert_id;
	}

}
