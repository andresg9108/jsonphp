"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
	validateSession(false);
    
    let sMessage = getErrorMessage();
    $("#messageerr").html(sMessage);
}

/*
*/
function recoverPasswordAction(){
	if(validateRecoverPassword()){
		let sEmail = $("#email").val();
		let sResponse = '';
        if(g_bReCaptcha){
            sResponse = $("#g-recaptcha-response").val();
        }

		let oDatos = {};
	    let sUrl = 'administration/publicData/appRegistration';
	    $.when($.post(g_sBackEnd+sUrl, oDatos))
	    .then(function(oResponse){
	        let aResponse = oResponse.response;
	        let iId = aResponse.id;
	        let sRegCod = aResponse.registration_code;
	        sRegCod = getDecodeRegCod(sRegCod);

	        let oDatos2 = {
	            'id': iId,
	            'registration_code': sRegCod,
	            'response': sResponse,
	            'email': sEmail
	        };
	        let sUrl2 = 'administration/user/recoverPassword';
	        $.when($.post(g_sBackEnd+sUrl2, oDatos2))
	        .then(function(oResponse){
	        	if(oResponse.status == 1){
	        		let sResponse = oResponse.text.client;
                    oResponse = oResponse.response;
                    let aEmail = oResponse.email;

                    $.when(sendEmail(aEmail))
                    .then(function(oResponse){
                        setErrorMessage(sResponse);
                        updatePage();
                    })
                    .fail(function(){});
	        	}else{
	        		setErrorMessage(oResponse.text.client);
                    updatePage();
	        	}
	        })
	        .fail(function(){});
	    })
	    .fail(function(){});
	}

    return false;
}

/*
*/
function validateRecoverPassword(){
	let sFieldName = '';
    let sFieldName2 = '';
    let sText = '';

    sFieldName = 'email';
    sText = 'You must add an email.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'Add a valid email.';
    if(!validateEmail(sFieldName, sText)){return false;}

    sText = 'You must complete the Captcha for security.';
    if(!validateReCaptcha(sText)){return false;}

	return true;
}