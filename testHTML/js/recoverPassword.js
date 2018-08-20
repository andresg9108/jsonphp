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