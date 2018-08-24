<?php

namespace model\person;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Util\{Util, constantGlobal};
use lib\MVC\proxy;
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
	      $oSendEmail = sendEmail::getInstance($oConnection);
	      $oUser = user::getInstance($oConnection);

	      // INIT VALIDATE EMAIL AND USER
	      foreach ($aUsersSet as $i => $v) {
	      	$sEmail = (!empty($v->email)) ? $v->email : '';
	      	$sUser = (!empty($v->user)) ? $v->user : '';

	      	$bUser = false;
	      	$oUser->iId = null;
	      	$oUser->sUser = $sUser;
	      	$oUser->loadXUser();
	      	if(!is_null($oUser->iId)){ $bUser = true; }

	      	$bEmail = false;
	      	$oUser->iId = null;
	      	$oUser->sEmail = $sEmail;
	      	$oUser->loadXEmail();
	      	if(!is_null($oUser->iId)){ $bEmail = true; }

	      	if($bEmail){
		      throw new systemException('', 1);
		    }
		    if($bUser){
		      throw new systemException('', 1);
		    }
	      }
	      // END VALIDATE EMAIL AND USER

	      $oPerson->sName = $sName;
	      $oPerson->sLastName = $sLastName;
	      $oPerson->aUsers = $aUsersSet;
	      $oPerson->save();

	      // SEND EMAIL
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
	      	$aParameters = [$sUrl];
	      	$sMessage = constantGlobal::getConstant('EMAIL_CHECKIN_MESSAGE', $aParameters);

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

	      $aResponse = [];
	      $aResponse['registered'] = true;
	      $aResponse['email'] = $aEmail;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Util::getResponseArray(true, (object)$aResponse,
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
