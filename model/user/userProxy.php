<?php

namespace model\user;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal};
use lib\MVC\proxy;
use model\{connection, systemException};
use model\user\{user, constantUser};
use model\emailUser\emailUser;
use model\sendEmail\sendEmail;

class userProxy extends proxy {

	/*
	*/
	public static function sendRecoverPassword($iIdEUser, $sCodeEUser, $sPassword){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oUser = user::getInstance($oConnection);
	      $oEmailUser = emailUser::getInstance($oConnection);

	      $oEmailUser->iId = $iIdEUser;
	      $oEmailUser->load();

	      if(empty($oEmailUser->iId) || $sCodeEUser != $oEmailUser->sRegistrationCode){
	      	throw new systemException(constantUser::getConstant('FAIL_VALIDATE_RECOVER_PASSWORD'));
	      }

	      $sCode = Useful::getRandomCode();
	      $oEmailUser->sRegistrationCode = $sCode;
	      $oEmailUser->save();

	      $oUser->iId = $oEmailUser->iIdUser;
	      $oUser->load();
	      $oUser->sPassword = $sPassword;
	      $oUser->save();

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)[],
	      	constantUser::getConstant('SUCCESSFUL_SEND_RECOVER_PASSWORD'), 
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

	/*
	*/
	public static function validateRecoverPassword($iIdEUser, $sCodeEUser){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oUser = user::getInstance($oConnection);
	      $oEmailUser = emailUser::getInstance($oConnection);

	      $oEmailUser->iId = $iIdEUser;
	      $oEmailUser->load();

	      if(empty($oEmailUser->iId) || $sCodeEUser != $oEmailUser->sRegistrationCode){
	      	throw new systemException(constantUser::getConstant('FAIL_VALIDATE_RECOVER_PASSWORD'));
	      }

	      $sCode = Useful::getRandomCode();
	      $oEmailUser->sRegistrationCode = $sCode;
	      $oEmailUser->iStatus = 1;
	      $oEmailUser->save();

	      $oUser->iId = $oEmailUser->iIdUser;
	      $oUser->load();
	      $oUser->iStatus = 1;
	      $oUser->save();

	      $aResponse = [];
	      $aResponse['ideuser'] = $oEmailUser->iId;
	      $aResponse['codeeuser'] = $oEmailUser->sRegistrationCode;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$aResponse,
	      	'', 
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

	/*
	*/
	public static function validateEmailByCode($iIdUser, $sCodeEmailUser){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oUser = user::getInstance($oConnection);
	      $oEmailUser = emailUser::getInstance($oConnection);

	      $oEmailUser->iIdUser = $iIdUser;
	      $oEmailUser->loadMainByIdUser();
	      $sCodeEmailUserBD = $oEmailUser->sRegistrationCode;

	      if(empty($sCodeEmailUserBD) || $sCodeEmailUser != $sCodeEmailUserBD){
	      	throw new systemException(constantUser::getConstant('FAIL_VALIDATE_USER_BY_EMAIL'));
	      }

	      $sCode = Useful::getRandomCode();
	      $oEmailUser->iStatus = 1;
	      $oEmailUser->sRegistrationCode = $sCode;
	      $oEmailUser->save();

	      $oUser->iId = $iIdUser;
	      $oUser->load();
	      $oUser->iStatus = 1;
	      $oUser->save();

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)[],
	      	constantUser::getConstant('SUCCESSFUL_VALIDATE_USER_BY_EMAIL'), 
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

	/*
	*/
	public static function recoverPassword($sEmail){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      if(empty($sEmail)){
	      	throw new systemException(constantUser::getConstant('VAL_EMPTY_EMAIL_RECOVER_PASSWORD'));
	      }

	      if(!Useful::validateEmail($sEmail)){
	      	throw new systemException(constantUser::getConstant('VAL_VAL_EMAIL_RECOVER_PASSWORD'));
	      }


	      $oEmailUser = emailUser::getInstance($oConnection);
	      $oSendEmail = sendEmail::getInstance($oConnection);

	      $oEmailUser->iId = null;
	      $oEmailUser->sEmail = $sEmail;
	      $oEmailUser->loadByEmail();

	      if(empty($oEmailUser->iId)){
	      	throw new systemException(constantUser::getConstant('FAIL_EMAIL_RECOVER_PASSWORD'));
	      }

	      // SEND EMAIL
	      $iIdEmailSettings = 2;
	      $aParameters = [$oEmailUser->iId, $oEmailUser->sRegistrationCode];
	      $sUrl = constantUser::getConstant('EMAIL_RECOVER_PASSWORD_URL', $aParameters);
	      $sSubject = constantUser::getConstant('EMAIL_SUBJECT_RECOVER_PASSWORD');
	      $aParameters = [$sUrl];
	      $sMessage = Useful::getEmailTemplate('recoverPassword', $aParameters);

	      $aEmail = [];
	      $oEmail = Useful::saveEmail($oEmailUser->sEmail, $iIdEmailSettings, 
	      		$sSubject, $sMessage, $oConnection);
	      $aEmail[] = $oEmail;
	      // END EMAIL

	      $aResponse = [];
	      $aResponse['email'] = $aEmail;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$aResponse,
	      	constantUser::getConstant('SUCCESSFUL_RECOVER_PASSWORD'), 
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

	/*
	*/
	public static function validateEmailAndUser($sEmail, $sUser){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $sEmail = str_replace(' ', '', $sEmail);
	      $sUser = str_replace(' ', '', $sUser);

	      $oUser = user::getInstance($oConnection);
	      $oEmailUser = emailUser::getInstance($oConnection);

	      $bEmail = false;
	      $oEmailUser->iId = null;
	      $oEmailUser->sEmail = $sEmail;
	      $oEmailUser->loadByEmail();
	      if(!is_null($oEmailUser->iId)){ $bEmail = true; }

	      $bUser = false;
	      $oUser->iId = null;
	      $oUser->sUser = $sUser;
	      $oUser->loadByUser();
	      if(!is_null($oUser->iId)){ $bUser = true; }

	      $aResponse = [];
	      $aResponse['user'] = $bUser;
	      $aResponse['email'] = $bEmail;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$aResponse,
	      	"", 
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

	/*
	*/
	public static function validatelogIn($oUserSet){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $sUser = (!empty($oUserSet->user)) ? $oUserSet->user : '';
	      $sPassword = (!empty($oUserSet->password)) ? $oUserSet->password : '';
	      $sUser = str_replace(' ', '', $sUser);
	      $sPassword = md5($sPassword);

	      $oUser = user::getInstance($oConnection);
	      $oUser->sUser = $sUser;
	      $oUser->loadByUser();
	      $sPasswordBD = $oUser->sPassword;
	      $iStatus = $oUser->iStatus;
	      $bStatus = ($iStatus == 1) ? true : false;

	      if(empty($sPasswordBD) || $sPassword !== $sPasswordBD){
	      	throw new systemException(constantUser::getConstant('FAIL_VALIDATE_LOGIN'));
	      }

	      if(!$bStatus){
	      	throw new systemException(constantUser::getConstant('FAIL_VALIDATE_USER'));
	      }

	      $aResponse = [];
	      $aObject = [];
	      $aObject['id'] = $oUser->iId;
	      $aObject['profile'] = $oUser->iIdProfile;
	      $oObject = (object)$aObject;
	      $sCode = Useful::getJWT($oObject);
	      $aResponse['code'] = $sCode;
	      $aResponse['profile'] = $oUser->iIdProfile;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Useful::getResponseArray(1, (object)$aResponse,
	      	"", 
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
