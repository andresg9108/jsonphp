<?php

namespace model\sendEmail;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal};
use lib\MVC\proxy;
use model\{connection, systemException};
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

	      $aResponse = [];
	      $aResponse['email'] = $oSendEmail->sEmail;
	      $aResponse['subject'] = $oSendEmail->sSubject;
	      $aResponse['message'] = $oSendEmail->sMessage;
	      $oSendEmail->delete();

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$aResponse,
	      	"", 
	      	constantGlobal::SUCCESSFUL_REQUEST);
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), '(Code: '.$e->getCode().') ' . $e->getMessage());
	    } catch (ExpiredException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
		}
	}
}