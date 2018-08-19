"use strict";

var g_sBackEnd = 'http://localhost/jsonphp/';
var g_bEncryptionRedCod = true;
var g_iPrivateKey = 15628;
var g_sPrivateKey = "a5vbFgFFG4Fd2";

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