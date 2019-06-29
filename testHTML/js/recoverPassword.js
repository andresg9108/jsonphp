"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
	validateSession(false);
    
    let sMessage = getMessage();
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

        let oAjax = {
	        url: g_sBackEnd+'module/publicData/appRegistration',
	        type: 'post',
	        data: {}
	    }
	    $.ajax(oAjax).done(function(oResponse){
	        if(oResponse.status == 1){
	            let aResponse = oResponse.response;
	            let iId = aResponse.id;
	            let sRegCod = aResponse.registration_code;
	            sRegCod = getDecodeRegCod(sRegCod);

	            oAjax = {
			        url: g_sBackEnd+'module/user/recoverPassword',
			        type: 'post',
			        data: {
			            'id': iId,
			            'registration_code': sRegCod,
			            'response': sResponse,
			            'email': sEmail
			        }
			    }
			    $.ajax(oAjax).done(function(oResponse){
			    	if(oResponse.status == 1){
		        		let sResponse = oResponse.text.client;
	                    oResponse = oResponse.response;
	                    let aEmail = oResponse.email;

	                    $.when(sendEmail(aEmail))
	                    .then(function(oResponse){
	                        setMessage(sResponse);
	                        updatePage();
	                    })
	                    .fail(function(){});
		        	}else{
		        		setMessage(oResponse.text.client);
	                    updatePage();
		        	}
			    }).fail(function(){});
	        }else{
	        	setMessage(oResponse.text.client);
            	goTo('', '');
	        }
	    }).fail(function(){});
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
    sText = g_oMGlobal.YOU_MUST_ADD_AN_EMAIL[g_iIdLanguage];
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = g_oMGlobal.YOU_MUST_ADD_A_VALID_EMAIL[g_iIdLanguage];
    if(!validateEmail(sFieldName, sText)){return false;}

    sText = g_oMGlobal.YOU_MUST_COMPLETE_CAPTCHA[g_iIdLanguage];
    if(!validateReCaptcha(sText)){return false;}

	return true;
}