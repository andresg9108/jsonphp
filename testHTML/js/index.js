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
function logInAction(){
    let sUser = $("#user").val();
    let sPassword = $("#password").val();
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
    .fail(function(){});

    return false;
}