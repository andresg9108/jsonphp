<?php

namespace model\user;

use lib\MVC\proxy;
use lib\Util\{Util, constantGlobal};
use model\{connection, systemException};
use model\user\user;

class userProxy extends proxy {

	/*
	*/
	public static function validateEmailByCode($iIdUser, $sCodeUser){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oUser = user::getInstance($oConnection);
	      $oUser->iId = $iIdUser;
	      $oUser->load();
	      $iId = (!empty($oUser->iId)) ? $oUser->iId : null;
	      $sRegistrationCode = (!empty($oUser->sRegistrationCode)) ? $oUser->sRegistrationCode : '';

	      $aResponse = [];
	      $aResponse['valid'] = false;
	      if(!is_null($iId) && !empty($sRegistrationCode && $sRegistrationCode == $sCodeUser)){
	      	$aResponse['valid'] = true;
	      	$sCode = Util::getRandomCode();
	      	$oUser->iStatus = 1;
	      	$oUser->sRegistrationCode = $sCode;
	      	$oUser->update();
	      }


	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Util::getResponseArray(true, (object)$aResponse,
	      	"OK", "OK");
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
	    		$oUser->sMessageErr,
	    		constantGlobal::CONTROLLED_EXCEPTION);
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
		      	constantGlobal::CONTACT_SUPPORT,
		        $e->getMessage());
	    }
	}

	/*
	*/
	public static function validateEmailAndUser($sEmail, $sUser){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $oUser = user::getInstance($oConnection);
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

	      $aResponse = [];
	      $aResponse['user'] = $bUser;
	      $aResponse['email'] = $bEmail;

	      $oConnection->commit();
	      $oConnection->close();
	      
	      return Util::getResponseArray(true, (object)$aResponse,
	      	"OK", "OK");
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
	    		$oUser->sMessageErr,
	    		constantGlobal::CONTROLLED_EXCEPTION);
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
		      	constantGlobal::CONTACT_SUPPORT,
		        $e->getMessage());
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
	      
	      return Util::getResponseArray(true, (object)$aResponse,
	      	"OK", "OK");
	    } catch (systemException $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
	    		$oUser->sMessageErr,
	    		constantGlobal::CONTROLLED_EXCEPTION);
	    } catch (Exception $e) {
	    	$oConnection->rollback();
	    	$oConnection->close();

	    	return Util::getResponseArray(false, (object)[],
		      	constantGlobal::CONTACT_SUPPORT,
		        $e->getMessage());
	    }
	}

	/*
	*/
	public static function validateEmail($oUserSet){
		try {
	      $oConnection = connection::getInstance();
	      $oConnection->connect();

	      $iId = (!empty($oUserSet->id)) ? $oUserSet->id : null;
	      $sRegistrationCode = (!empty($oUserSet->registration_code)) ? $oUserSet->registration_code : '';

	      $oUser = user::getInstance($oConnection);
	      $oUser->iId = $iId;
	      $oUser->load();
	      $sRegistrationCodeBD = $oUser->sRegistrationCode;

	      $aResponse = [];
	      if(!empty($sRegistrationCodeBD) && $sRegistrationCode == $sRegistrationCodeBD){
	      	$sRegistrationCode = Util::getRandomCode();
	      	$oUser->sRegistrationCode = $sRegistrationCode;
	      	$oUser->iStatus = 1;
	      	$oUser->update();
	      	$aResponse['valid'] = true;
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
	    		$oUser->sMessageErr,
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

