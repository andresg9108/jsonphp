"use strict";

$(function(){
	setView();
});

/*
*/
function setView(){
}

/*
*/
function recoverPasswordAction(){
	if(validateRecoverPassword()){
		let sEmail = $("#email").val();

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
	            'email': sEmail
	        };
	        let sUrl2 = 'administration/user/recoverPassword';
	        $.when($.post(g_sBackEnd+sUrl2, oDatos2))
	        .then(function(oResponse){
	        	console.log(oResponse);
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
    sText = 'Debes ingresar el email de tu cuenta.';
    if(!validateTexto(sFieldName, sText)){return false;}

	return true;
}