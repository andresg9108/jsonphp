<?php

namespace model\person;

use \Exception;
use lib\MVC\proxy;
use lib\Util\{Util, constantGlobal};
use model\{connection, systemException};
use model\sendEmail\sendEmail;

class personProxy extends proxy {

	public static function save($oPersonSet){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $sName = (!empty($oPersonSet->name)) ? $oPersonSet->name : '';
	      $sLastName = (!empty($oPersonSet->last_name)) ? $oPersonSet->last_name : '';
	      $aUsersSet = (!empty($oPersonSet->users)) ? $oPersonSet->users : (object)[];

	      $oPerson = person::getInstance($oConnection);
	      $oPerson->sName = $sName;
	      $oPerson->sLastName = $sLastName;
	      $oPerson->aUsers = $aUsersSet;
	      $oPerson->save();

	      // SEND EMAIL
	      $aEmail = [];
	      foreach ($aUsersSet as $i => $v) {
	      	$sEmail = (!empty($v->email)) ? $v->email : '';
	      	$sCode = Util::getRandomCode();

	      	$oSendEmail = sendEmail::getInstance($oConnection);
	      	$oSendEmail->iId = null;
	      	$oSendEmail->sEmail = $sEmail;
	      	$oSendEmail->sCode = $sCode;
	      	$oSendEmail->iIdEmail = 1;

	      	$oSendEmail->sSubject = constantGlobal::getConstant('EMAIL_CHECKIN_SUBJECT');
	      	$oSendEmail->sMessage = constantGlobal::getConstant('EMAIL_CHECKIN_MESSAGE');
	      	$oSendEmail->save();

	      	$aRow = [];
	      	$aRow['id'] = $oSendEmail->iId;
	      	$aRow['cod'] = $oSendEmail->sCode;
	      	$oRow = (object)$aRow;
	      	$aEmail[] = $oRow;
	      }
	      // END EMAIL

	      $oResponse = [];
	      $oResponse['email'] = $aEmail;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Util::getResponseArray(true, (object)$oResponse,
	      	"OK", "OK");
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
	    		$oPerson->sMessageErr,
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

