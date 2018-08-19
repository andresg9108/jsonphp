<?php

namespace model;

use \Exception;
use \mysqli;
use lib\Util\Util;

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
		$oConnection = Util::getConnectionArray();

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
	public function connectMySQL(){
		$this->oConnection = @new mysqli($this->sServer, $this->sUser, $this->sPassword, $this->sDatabase);
		$this->oConnection->set_charset('utf8');
	    if($this->oConnection->connect_error)
	    	throw new Exception("Error de conexion: ".$this->oConnection->connect_error);

	    $this->oConnection->autocommit(FALSE);
	}

	/*
	*/
	public function runMySQL($sQuery){
		if($this->oConnection->connect_error)
			throw new Exception("Error de conexion: ".$this->oConnection->connect_error);
	    if(!@$this->oConnection->query(utf8_encode($sQuery)))
	    	throw new Exception("Error en la query: ".$sQuery);
	}

	/*
	*/
	public function queryRowMySQL($sQuery, $aParameters){
		if($this->oConnection->connect_error)
			throw new Exception("Error de conexion: ".$this->oConnection->connect_error);
	    $oQuery = @$this->oConnection->query($sQuery);
	    if(!$oQuery)
	    	throw new Exception("Error en la query: ".$sQuery);

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
	public function queryArrayMySQL($sQuery, $aParameters){
		if($this->oConnection->connect_error)
			throw new Exception("Error de conexion: ".$this->oConnection->connect_error);
	    $oQuery = @$this->oConnection->query($sQuery);
	    if(!$oQuery)
	    	throw new Exception("Error en la query: ".$sQuery);

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
	public function commitMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->commit();
	}

	/*
	*/
	public function rollbackMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->rollback();
	}

	/*
	*/
	public function closeMySQL(){
		if(!$this->oConnection->connect_error)
			@$this->oConnection->close();
	}

  	/*
	*/
	public function getIDInsertMySQL(){
		if(!$this->oConnection->connect_error)
			return @$this->oConnection->insert_id;
	}

}

?>