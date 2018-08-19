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
    let sEmail = $("#rc_email").val();

    console.log(sEmail);

    return false;
}

/*
*/
function logInAction(){
    let sUser = $("#l_user").val();
    let sPassword = $("#l_password").val();

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
            'user': sUser,
            'password': sPassword
        };
        let sUrl2 = 'administration/user/logIn';
        $.when($.post(g_sBackEnd+sUrl2, oDatos2))
        .then(function(oResponse){
            console.log(oResponse);
        })
        .fail(function(){});
    })
    .fail(function(){

    });

    return false;
}

/*
*/
function checkInAction(){
    if(validateCheckInAction()){
        let sName = $("#r_name").val();
        let sLastName = $("#r_last_name").val();
        let sEmail = $("#r_email").val();
        let sUser = $("#r_user").val();
        let sPassword = $("#r_password").val();

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
                'name': sName,
                'last_name': sLastName,
                'email': sEmail,
                'user': sUser,
                'password': sPassword
            };
            let sUrl2 = 'administration/user/checkIn';
            $.when($.post(g_sBackEnd+sUrl2, oDatos2))
            .then(function(oResponse){
                if(oResponse.status){
                    oResponse = oResponse.response;
                    let aEmail = oResponse.email;

                    $.each(aEmail, function(i, v){
                        let iId = v.id;
                        let sCod = v.cod;

                        let sUrl3 = 'administration/email/send';
                        let oDatos3 = {
                            'id': iId,
                            'cod': sCod
                        };
                        $.post(g_sBackEnd+sUrl3,oDatos3);
                    });

                    console.log('Registro OK.');
                }else{
                    console.log(oResponse.text.client);
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
function getDecodeRegCod(sRegCod){
	if(g_bEncryptionRedCod){
		let aRegCod = sRegCod.split('.');
		let iRegCod = 0;

    	$.each(aRegCod, function(i, v){
    		let iDato = parseInt(v);
    		let iDato2 = iDato+g_iPrivateKey;
    		iRegCod += iDato2;
    	});

    	sRegCod = String(iRegCod);
        sRegCod += g_sPrivateKey;
        sRegCod = md5(sRegCod);
	}

	return sRegCod;
}

/*
*/
function validateCheckInAction(){
    let sFieldName = '';
    let sText = '';

    sFieldName = 'r_name';
    sText = 'Debes agregar un nombre.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_last_name';
    sText = 'Debes agregar un apellido.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_email';
    sText = 'Debes agregar un email.';
    if(!validateTexto(sFieldName, sText)){return false;}
    sText = 'Agrega un email válido.';
    if(!validateEmail(sFieldName, sText)){return false;}

    sFieldName = 'r_user';
    sText = 'Debes agregar un usuario.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_password';
    sText = 'Debes agregar un password.';
    if(!validateTexto(sFieldName, sText)){return false;}

    sFieldName = 'r_rpassword';
    sText = 'Debes repetir el password.';
    if(!validateTexto(sFieldName, sText)){return false;}

    return true;
}