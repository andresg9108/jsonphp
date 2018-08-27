<?php

namespace model\sendEmail;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Util\{Util, constantGlobal};
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
	      $aResponse = [];
	      if(!empty($sCodBD) && $sCod === $sCodBD){
	      	$aResponse['valid'] = true;
	      	$aResponse['email'] = $oSendEmail->sEmail;
	      	$aResponse['subject'] = $oSendEmail->sSubject;
	      	$aResponse['message'] = $oSendEmail->sMessage;
	      	$oSendEmail->delete();
	      }else{
	      	$aResponse['valid'] = false;
	      }


	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Util::getResponseArray(1, (object)$aResponse,
	      	"", 
	      	constantGlobal::SUCCESSFUL_REQUEST);
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return $oResponse = Util::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Util::getResponseArray(3, (object)[], constantGlobal::CONTACT_SUPPORT, '(Code: '.$e->getCode().') ' . $e->getMessage());
	    } catch (ExpiredException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();
	    	return Util::getResponseArray(4, (object)[], constantGlobal::ERROR_SESSION, constantGlobal::ERROR_SESSION);
		}
	}
}
