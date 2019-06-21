<?php

namespace model\appRegistration;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal};
use lib\MVC\proxy;
use model\{connection, systemException};
use model\appRegistration\{appRegistration, constantAppRegistration};

class appRegistrationProxy extends proxy {

	/*
	*/
	public static function validateRegCod($iId, $sRegistrationCode){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oAppRegistration = appRegistration::getInstance($oConnection);
	      $oAppRegistration->iId = $iId;
	      $oAppRegistration->load();
	      $sRegistrationCodeBD =  $oAppRegistration->sRegistrationCode;
	      $sRegistrationCodeBD = Useful::getDecodeRegCod($sRegistrationCodeBD);

	      if(empty($sRegistrationCodeBD) || $sRegistrationCode !== $sRegistrationCodeBD){
	      	throw new systemException(constantGlobal::getConstant('CONTACT_SUPPORT'));
	      }
	      $oAppRegistration->delete();

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)[],
	      	"", 
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

	/*
	*/
	public static function save($oAppRegistrationSet){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $iNumberItems = 5;
	      $sRegistrationCode = '';
	      for ($i=0; $i < $iNumberItems; $i++) {
	      	$sCodeItem = (string)rand(10000, 99999);
	      	if($i == 0)
	      		$sRegistrationCode .= $sCodeItem;
	      	else
	      		$sRegistrationCode .= '.'.$sCodeItem;
	      }

	      $oAppRegistration = appRegistration::getInstance($oConnection);
	      $oAppRegistration->sRegistrationCode = $sRegistrationCode;
	      $oAppRegistration->save();

	      $oResponse = [];
	      $oResponse['id'] = $oAppRegistration->iId;
	      $oResponse['registration_code'] = $oAppRegistration->sRegistrationCode;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$oResponse,
	      	"", 
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
