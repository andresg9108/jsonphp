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
	public static function validateRegCod($oAppRegistrationSet){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $iId = (!empty($oAppRegistrationSet->id)) ? $oAppRegistrationSet->id : null;
	      $sRegistrationCode = (!empty($oAppRegistrationSet->registration_code)) ? $oAppRegistrationSet->registration_code : '';

	      $oAppRegistration = appRegistration::getInstance($oConnection);
	      $oAppRegistration->iId = $iId;
	      $oAppRegistration->load();
	      $sRegistrationCodeBD =  $oAppRegistration->sRegistrationCode;
	      $sRegistrationCodeBD = Useful::getDecodeRegCod($sRegistrationCodeBD);

	      $oResponse = [];
	      if($sRegistrationCode == $sRegistrationCodeBD){
	      	$oResponse['validate'] = true;

	      	$oAppRegistration->delete();
	      }else{
	      	$oResponse['validate'] = false;
	      }

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$oResponse,
	      	"", 
	      	constantGlobal::SUCCESSFUL_REQUEST);
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return $oResponse = Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().') ' . $e->getMessage());
	    } catch (ExpiredException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
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
	      	constantGlobal::SUCCESSFUL_REQUEST);
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return $oResponse = Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().') ' . $e->getMessage());
	    } catch (ExpiredException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
		}
	}
}
