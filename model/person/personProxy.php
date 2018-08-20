<?php

namespace model\person;

use \Exception;
use lib\MVC\proxy;
use lib\Util\{Util, constantGlobal};
use model\{connection, systemException};
use model\user\user;
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
	      $oSendEmail = sendEmail::getInstance($oConnection);
	      $oUser = user::getInstance($oConnection);
	      $oUser->iIdPerson = $oPerson->iId;
	      $aUser = $oUser->getUsersByIdPerson();

	      $aEmail = [];
	      foreach ($aUser as $i => $v){
			$iIdUser = (!empty($v->id)) ? $v->id : null;
			$sEmail = (!empty($v->email)) ? $v->email : '';
			$sRegistrationCode = (!empty($v->registration_code)) ? $v->registration_code : '';
			$iIdEmail = 1;
			$sCode = Util::getRandomCode();

			$aParameters = [$iIdUser, $sRegistrationCode];
	      	$sUrl = constantGlobal::getConstant('EMAIL_CHECKIN_URL', $aParameters);
	      	$sSubject = constantGlobal::getConstant('EMAIL_CHECKIN_SUBJECT');
	      	$sSubject = str_replace("'", '"', $sSubject);
	      	$aParameters = [$sUrl];
	      	$sMessage = constantGlobal::getConstant('EMAIL_CHECKIN_MESSAGE', $aParameters);
	      	$sMessage = str_replace("'", '"', $sMessage);

	      	$oSendEmail->iId = null;
	      	$oSendEmail->sEmail = $sEmail;
	      	$oSendEmail->sCode = $sCode;
	      	$oSendEmail->iIdEmail = $iIdEmail;
	      	$oSendEmail->sSubject = $sSubject;
	      	$oSendEmail->sMessage = $sMessage;
	      	$oSendEmail->save();

	      	$aEmailRow = [];
	      	$aEmailRow['id'] = $oSendEmail->iId;
	      	$aEmailRow['cod'] = $oSendEmail->sCode;
	      	$oEmailRow = (object)$aEmailRow;
	      	$aEmail[] = $oEmailRow;
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

