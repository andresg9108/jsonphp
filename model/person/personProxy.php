<?php

namespace model\person;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use lib\MVC\proxy;
use andresg9108\connectiondb\connection;
use model\person\{person, constantPerson};
use model\user\user;
use model\emailUser\emailUser;
use model\sendEmail\sendEmail;

class personProxy extends proxy {

	public static function checkIn($oPersonSet){
		$oConnection = Useful::getConnectionDB();
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
			$iIdEmailSettings = 1;
		$iIdUser = (!empty($v->id)) ? $v->id : null;
		$oEmailUser->iIdUser = $iIdUser;
		$oEmailUser->loadMainByIdUser();

		$sUrlFrontend = constantGlobal::getConstant('URL_FRONTEND');
		$aParameters = [$iIdUser, $oEmailUser->sRegistrationCode];
			$sUrl = constantPerson::getConstant('EMAIL_CHECKIN_URL', $aParameters);
			$sUrl = $sUrlFrontend.$sUrl;
			
			$sSubject = constantPerson::getConstant('EMAIL_CHECKIN_SUBJECT');
			$aParameters = [$sUrl];
			$sMessage = Useful::getEmailTemplate('checkin', $aParameters);

			$oEmail = Useful::saveEmail($oEmailUser->sEmail, $iIdEmailSettings, 
				$sSubject, $sMessage, $oConnection);
			$aEmail[] = $oEmail;
		}
		// END EMAIL

		$aResponse = [];
		$aResponse['email'] = $aEmail;

		$oConnection->commit();
		$oConnection->close();

		return (object)$aResponse;
	}
}
