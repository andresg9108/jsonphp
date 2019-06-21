"use strict";

$(function(){
    setView();
});

/*
*/
function setView(){
	validateSession(true);

	let sMessage = getMessage();
    $("#messageerr").html(sMessage);
}

/*
*/
function changePasswordAction(){
	if(validateChangePasswordAction()){
		console.log('OK');
	}

	return false;
}

/*
*/
function validateChangePasswordAction(){
    let sFieldName = '';
    let sFieldName2 = '';
    let sText = '';

    sFieldName = 'password';
    sText = g_oMGlobal.YOU_MUST_ADD_A_PASSWORD[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.PASSWORD_LEAST_5_CHARACTERS[g_iIdLanguage];
    if(!validatePassword(sFieldName, sText)){ return false; }

    sFieldName = 'rpassword';
    sText = g_oMGlobal.YOU_MUST_REPEAT_THE_PASSWORD[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'password';
    sFieldName2 = 'rpassword';
    sText = g_oMGlobal.PASSWORDS_DO_NOT_MATCH[g_iIdLanguage];
    if(!validatePasswords(sFieldName, sFieldName2, sText)){ return false; }

    sText = g_oMGlobal.YOU_MUST_COMPLETE_CAPTCHA[g_iIdLanguage];
    if(!validateReCaptcha(sText)){return false;}

    return true;
}