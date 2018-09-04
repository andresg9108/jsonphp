<?php

namespace model\person;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal};
use lib\MVC\proxy;
use model\{connection, systemException};
use model\person\{person, constantPerson};
use model\user\user;
use model\emailUser\emailUser;
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
	      $oEmailUser = emailUser::getInstance($oConnection);

	      $oPerson->sName = $sName;
	      $oPerson->sLastName = $sLastName;
	      $oPerson->aUser = $aUsersSet;
	      $oPerson->save();

	      // SEND EMAIL
	      $oUser->iIdPerson = $oPerson->iId;
	      $aUser = $oUser->getUsersByIdPerson();

	      $aEmail = [];
	      foreach ($aUser as $i => $v){
			$iIdUser = (!empty($v->id)) ? $v->id : null;
			$iIdEmail = 1;
			$sCode = Useful::getRandomCode();
			$oEmailUser->iIdUser = $iIdUser;
			$oEmailUser->loadMainByIdUser();

			$aParameters = [$iIdUser, $oEmailUser->sRegistrationCode];
	      	$sUrl = constantPerson::getConstant('EMAIL_CHECKIN_URL', $aParameters);
	      	$sSubject = constantPerson::getConstant('EMAIL_CHECKIN_SUBJECT');
	      	$aParameters = [$sUrl];
	      	$sMessage = Useful::getEmailTemplate('checkin', $aParameters);

	      	$oSendEmail->iId = null;
	      	$oSendEmail->sEmail = $oEmailUser->sEmail;
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
	      $aResponse['email'] = $aEmail;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$aResponse,
	      	constantPerson::getConstant('SUCCESSFUL_REGISTRATION'), 
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
