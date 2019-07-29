<?php

namespace model\appRegistration;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use lib\MVC\proxy;
use andresg9108\connectiondb\connection;
use model\appRegistration\{appRegistration, constantAppRegistration};

class appRegistrationProxy extends proxy {

	/*
	*/
	public static function validateRegCod($iId, $sRegistrationCode){
		$oConnection = Useful::getConnectionDB();
		$oConnection->connect();

		$oAppRegistration = appRegistration::getInstance($oConnection);
		$oAppRegistration->iId = $iId;
		$oAppRegistration->load();
		$sRegistrationCodeBD =  $oAppRegistration->sRegistrationCode;
		$sRegistrationCodeBD = Useful::getDecodeRegCod($sRegistrationCodeBD);

		if(empty($sRegistrationCodeBD) || $sRegistrationCode !== $sRegistrationCodeBD){
			throw new systemException(constantGlobal::getConstant('CONTACT_SUPPORT'));
		}
		$oAppRegistration->delete();

		$oConnection->commit();
		$oConnection->close();

		return (object)[];
	}

	/*
	*/
	public static function save($oAppRegistrationSet){
		$oConnection = Useful::getConnectionDB();
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

		return (object)$oResponse;
	}
}
