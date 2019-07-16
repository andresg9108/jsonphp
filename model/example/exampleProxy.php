<?php

namespace model\example;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use lib\MVC\proxy;
use model\connection;
use model\example\{constantExample, queryExample};

class exampleProxy extends proxy {

	/*
	*/
	public static function getExample(){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)[],
	      	constantExample::getConstant('MY_CONSTANT'), 
	      	constantGlobal::getConstant('SUCCESSFUL_REQUEST'));
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), $e->getMessage());
	    } catch (ExpiredException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
		}
	}
}
