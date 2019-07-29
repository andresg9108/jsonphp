<?php

namespace model\sendEmail;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use lib\MVC\proxy;
use andresg9108\connectiondb\connection;
use model\sendEmail\{sendEmail, constantSendEmail};

class sendEmailProxy extends proxy {

	/*
	*/
	public static function validateEmailSending($oSendEmailSet){
		try {
			$oConnection = Useful::getConnectionDB();
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

			return (object)$aResponse;
		}catch(systemException $e){
			$oConnection->rollback();
			$oConnection->close();
			throw new systemException($e->getMessage());
		}catch(Exception $e){
			$oConnection->rollback();
			$oConnection->close();
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}

	/*
	*/
	public static function registerEmailSent($oSendEmailSet){
		try {
			$oConnection = Useful::getConnectionDB();
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

			return (object)[];
		}catch(systemException $e){
			$oConnection->rollback();
			$oConnection->close();
			throw new systemException($e->getMessage());
		}catch(Exception $e){
			$oConnection->rollback();
			$oConnection->close();
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}
}
