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
function addEmailAction(){
	if(validateAddEmailAction()){
		console.log('OK');
	}

	return false;
}

/*
*/
function validateAddEmailAction(){
    let sFieldName = '';
    let sFieldName2 = '';
    let sText = '';

    sFieldName = 'email';
    sText = g_oMGlobal.YOU_MUST_ADD_AN_EMAIL[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.YOU_MUST_ADD_A_VALID_EMAIL[g_iIdLanguage];
    if(!validateEmail(sFieldName, sText)){return false;}

    sText = g_oMGlobal.YOU_MUST_COMPLETE_CAPTCHA[g_iIdLanguage];
    if(!validateReCaptcha(sText)){return false;}

    return true;
}