<?php

namespace model\user;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Util\{Util, constantGlobal};
use lib\MVC\proxy;
use model\{connection, systemException};
use model\user\user;
use model\sendEmail\sendEmail;

class userProxy extends proxy {

	/*
	*/
	public static function recoverPassword($sEmail){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oUser = user::getInstance($oConnection);
	      $oSendEmail = sendEmail::getInstance($oConnection);

	      $oUser->iId = null;
	      $oUser->sEmail = $sEmail;
	      $oUser->loadXEmail();

	      $aResponse = [];
	      $aResponse['send_email'] = false;
	      if(!is_null($oUser->iId)){
	      	$aResponse['send_email'] = true;

	      	// SEND EMAIL
	      	$iIdUser = (!empty($oUser->iId)) ? $oUser->iId : null;
	      	$sEmail = (!empty($oUser->sEmail)) ? $oUser->sEmail : '';
	      	$sRegistrationCode = (!empty($oUser->sRegistrationCode)) ? $oUser->sRegistrationCode : '';
	      	$iIdEmail = 2;
	      	$sCode = Util::getRandomCode();

	      	$aParameters = [$iIdUser, $sRegistrationCode];
	      	$sUrl = constantGlobal::getConstant('EMAIL_RECOVERPASSWORD_URL', $aParameters);
	      	$sSubject = constantGlobal::getConstant('EMAIL_RECOVERPASSWORD_SUBJECT');
	      	$sSubject = str_replace("'", '"', $sSubject);
	      	$aParameters = [$sUrl];
	      	$sMessage = constantGlobal::getConstant('EMAIL_RECOVERPASSWORD_MESSAGE', $aParameters);
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

	      	$aResponse['email'] = [$oEmailRow];
	      	// END EMAIL
	      }

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Util::getResponseArray(1, (object)$aResponse,
	      	"Se ha enviado un email con los datos que corresponden a la recuperación de la contraseña.", 
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

	/*
	*/
	public static function validateEmailAndUser($sEmail, $sUser){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $sEmail = str_replace(' ', '', $sEmail);
	      $sUser = str_replace(' ', '', $sUser);

	      $oUser = user::getInstance($oConnection);

	      $bEmail = false;
	      $oUser->iId = null;
	      $oUser->sEmail = $sEmail;
	      $oUser->loadXEmail();
	      if(!is_null($oUser->iId)){ $bEmail = true; }

	      $bUser = false;
	      $oUser->iId = null;
	      $oUser->sUser = md5($sUser);
	      $oUser->loadXUser();
	      if(!is_null($oUser->iId)){ $bUser = true; }

	      $aResponse = [];
	      $aResponse['user'] = $bUser;
	      $aResponse['email'] = $bEmail;

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
	      $oUser->loadXUser();
	      $sPasswordBD = $oUser->sPassword;
	      $iStatus = $oUser->iStatus;
	      $bStatus = ($iStatus == 1) ? true : false;

	      $aResponse = [];
	      if(!empty($sPasswordBD) && $sPassword === $sPasswordBD){
	      	$aResponse['valid'] = true;
	      	$aResponse['status'] = $bStatus;
	      	if($bStatus){
	      		$aObject = [];
	      		$aObject['id'] = $oUser->iId;
	      		$aObject['profile'] = $oUser->iIdProfile;
	      		$oObject = (object)$aObject;
	      		$sCode = Util::getJWT($oObject);
	      		$aResponse['code'] = $sCode;
	      		$aResponse['profile'] = $oUser->iIdProfile;
	      	}
	      }else{
	      	$aResponse['valid'] = false;
	      	$aResponse['status'] = false;
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
