<?php

namespace model\sendEmail;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use lib\MVC\proxy;
use model\connection;
use model\sendEmail\{sendEmail, constantSendEmail};

class sendEmailProxy extends proxy {

	/*
	*/
	public static function validateEmailSending($oSendEmailSet){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $iId = (!empty($oSendEmailSet->id)) ? $oSendEmailSet->id : null;
	      $sCod = (!empty($oSendEmailSet->cod)) ? $oSendEmailSet->cod : '';

	      $oSendEmail = sendEmail::getInstance($oConnection);
	      $oSendEmail->iId = $iId;
	      $oSendEmail->load();
	      $sCodBD = $oSendEmail->sCode;

	      if(empty($sCodBD) || $sCod !== $sCodBD){
	      	throw new systemException(constantSendEmail::getConstant('FAIL_EMAIL_SEND'));
	      }

	      if($oSendEmail->iStatus == 1){
	      	throw new systemException(constantSendEmail::getConstant('STATUS_EMAIL_SENT'));
	      }

	      $aResponse = [];
	      $aResponse['email'] = $oSendEmail->sEmail;
	      $aResponse['subject'] = $oSendEmail->sSubject;
	      $aResponse['message'] = $oSendEmail->sMessage;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$aResponse,
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
	public static function registerEmailSent($oSendEmailSet){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $iId = (!empty($oSendEmailSet->id)) ? $oSendEmailSet->id : null;
	      $sCod = (!empty($oSendEmailSet->cod)) ? $oSendEmailSet->cod : '';

	      $oSendEmail = sendEmail::getInstance($oConnection);
	      $oSendEmail->iId = $iId;
	      $oSendEmail->load();
	      $sCodBD = $oSendEmail->sCode;

	      if(empty($sCodBD) || $sCod !== $sCodBD){
	      	throw new systemException(constantSendEmail::getConstant('FAIL_EMAIL_SEND'));
	      }

	      $oSendEmail->iStatus = 1;
	      $oSendEmail->save();

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)[],
	      	constantSendEmail::getConstant('EMAIL_HAS_BEEN_SEND'), 
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
