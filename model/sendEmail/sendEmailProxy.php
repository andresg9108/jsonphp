<?php

namespace model\sendEmail;

use lib\MVC\proxy;
use lib\Util\{Util, constantGlobal};
use model\{connection, systemException};
use model\sendEmail\sendEmail;

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
	      
	      return Util::getResponseArray(true, (object)$aResponse,
	      	"OK", "OK");
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
	    		$oSendEmail->sMessageErr,
	    		constantGlobal::CONTROLLED_EXCEPTION);
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
		      	constantGlobal::CONTACT_SUPPORT,
		        $e->getMessage());
	    }
	}
}

?>

